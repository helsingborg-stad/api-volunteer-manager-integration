import VolunteerServiceContext, {
  Volunteer,
  VOLUNTEER_ERROR,
} from '../../volunteer-service/VolunteerServiceContext'
import useAsync from '../../hooks/UseAsync'
import { useContext } from 'react'
import SignUpForm from './SignUpForm'
import { CircularProgress, Stack } from '@mui/material'
import { Button, Icon } from '@helsingborg-stad/municipio-react-ui'
import PhraseContext from '../../phrase/PhraseContextInterface'

type State = 'loading' | 'saving'
const volunteerHasSubmitted = (volunteer: Volunteer, assignmentId: string) =>
  volunteer.assignments?.find((a) => a.assignmentId === parseInt(assignmentId)) !== undefined
const volunteerCanSubmit = (volunteer: Volunteer, rejectStatus: string[] = ['new', 'denied']) =>
  volunteer.status && !rejectStatus.includes(volunteer.status)

export function SignUpToAssignment({
  assignmentId,
  closeDialog,
}: {
  assignmentId: string
  closeDialog: () => any
}): JSX.Element {
  const { getVolunteer, applyToAssignment } = useContext(VolunteerServiceContext)
  const { phrase } = useContext(PhraseContext)
  const inspect = useAsync<Volunteer, State>(getVolunteer, 'loading')
  return inspect({
    pending: (state, data) => (
      <SignUpForm
        volunteer={{
          ...{
            firstName: '....',
            lastName: '',
            id: '',
            email: '',
            phone: '',
            status: '',
          },
          ...(data ?? {}),
        }}
        onSubmit={() => console.log('')}>
        <CircularProgress
          className={'u-position--absolute u-color__text--secondary'}
          color="inherit"
        />
        <Stack spacing={4}>
          <div>
            <Stack spacing={1} direction={'column'}>
              <Button disabled color={'primary'}>
                {
                  {
                    loading: phrase('loading_text', 'Loading...'),
                    saving: phrase('saving_text', 'Saving...'),
                  }[state]
                }
              </Button>
              <span></span>
              <Button disabled color={'secondary'} onClick={closeDialog}>
                {phrase('logout_button_label', 'Logout')}
              </Button>
            </Stack>
          </div>
        </Stack>
      </SignUpForm>
    ),
    resolved: (volunteer, state, update) =>
      ({
        saving: (
          <SignUpForm volunteer={volunteer}>
            <Stack spacing={3}>
              <div className={'c-notice c-notice--success'}>
                <span className="c-notice__icon">
                  <Icon name={'check'} />
                </span>
                <span className="c-notice__message">
                  {phrase('after_sign_up_text', 'Thank you for your registration!')}
                </span>
              </div>
              <div>
                <Stack spacing={1} direction={'column'}>
                  <Button disabled color={'primary'}>
                    {phrase('sign_up_button_label', 'Sign up')}
                  </Button>
                  <span></span>
                  <Button color={'secondary'} onClick={closeDialog}>
                    {phrase('logout_button_label', 'Logout')}
                  </Button>
                </Stack>
              </div>
            </Stack>
          </SignUpForm>
        ),
        loading: {
          signUp: (
            <SignUpForm volunteer={volunteer}>
              <Stack spacing={4}>
                <div>
                  <Stack spacing={1} direction={'column'}>
                    <Button
                      color={'primary'}
                      onClick={() =>
                        update(
                          applyToAssignment(parseInt(assignmentId)).then(getVolunteer),
                          'saving',
                        )
                      }>
                      {phrase('sign_up_button_label', 'Sign up')}
                    </Button>
                    <span></span>
                    <Button color={'secondary'} onClick={closeDialog}>
                      {phrase('logout_button_label', 'Logout')}
                    </Button>
                  </Stack>
                </div>
              </Stack>
            </SignUpForm>
          ),
          notApproved: (
            <span>
              {phrase(
                'volunteer_not_approved_text',
                'Your volunteer application is pending, please try again later.',
              )}
            </span>
          ),
        }[`${volunteerCanSubmit(volunteer) ? 'signUp' : 'notApproved'}`],
      }[`${volunteerHasSubmitted(volunteer, assignmentId) ? 'saving' : state}`]),
    rejected: (err, state, update) =>
      ({
        loading: {
          [VOLUNTEER_ERROR.VOLUNTEER_DOES_NOT_EXIST]: (
            <span>
              {phrase('volunteer_not_registered_text', 'You are not registered as a volunteer.')}
            </span>
          ),
          error: (
            <span>{phrase('error_text', 'Something went wrong, please try again later.')}</span>
          ),
        }[
          err.name === VOLUNTEER_ERROR.VOLUNTEER_DOES_NOT_EXIST
            ? VOLUNTEER_ERROR.VOLUNTEER_DOES_NOT_EXIST
            : 'error'
        ],
        saving: (
          <span>{phrase('error_text', 'Something went wrong, please try again later.')}</span>
        ),
      }[state]),
  })
}

export default SignUpToAssignment
