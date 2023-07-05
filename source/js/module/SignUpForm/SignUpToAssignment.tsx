import VolunteerServiceContext, { Volunteer } from '../../volunteer-service/VolunteerServiceContext'
import useAsync from '../../hooks/UseAsync'
import { useContext } from 'react'
import SignUpForm from './SignUpForm'
import { CircularProgress, Stack } from '@mui/material'
import { Button, Icon } from '@helsingborg-stad/municipio-react-ui'

type State = 'loading' | 'saving'

export function SignUpToAssignment({
  assignmentId,
  closeDialog,
}: {
  assignmentId: string
  closeDialog: () => any
}): JSX.Element {
  const { getVolunteer, applyToAssignment } = useContext(VolunteerServiceContext)
  const inspect = useAsync<Volunteer, State>(getVolunteer, 'loading')
  const volunteerHasSubmitted = (volunteer: Volunteer, assignmentId: string) =>
    volunteer.assignments?.find((a) => a.assignmentId === parseInt(assignmentId)) !== undefined

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
                {'Vänligen vänta...'}
              </Button>
              <span></span>
              <Button disabled color={'secondary'} onClick={closeDialog}>
                {'Logga ut'}
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
                  {'Tack för ditt intresse! Du kommer att bli kontaktad av uppdragsgivaren.'}
                </span>
              </div>
              <div>
                <Stack spacing={1} direction={'column'}>
                  <Button disabled color={'primary'}>
                    {'Anmäl intresse'}
                  </Button>
                  <span></span>
                  <Button color={'secondary'} onClick={closeDialog}>
                    {'Logga ut'}
                  </Button>
                </Stack>
              </div>
            </Stack>
          </SignUpForm>
        ),
        loading: (
          <SignUpForm volunteer={volunteer}>
            <Stack spacing={4}>
              <div>
                <Stack spacing={1} direction={'column'}>
                  <Button
                    color={'primary'}
                    onClick={() =>
                      update(applyToAssignment(parseInt(assignmentId)).then(getVolunteer), 'saving')
                    }>
                    {'Anmäl intresse'}
                  </Button>
                  <span></span>
                  <Button color={'secondary'} onClick={closeDialog}>
                    {'Logga ut'}
                  </Button>
                </Stack>
              </div>
            </Stack>
          </SignUpForm>
        ),
      }[`${volunteerHasSubmitted(volunteer, assignmentId) ? 'saving' : state}`]),
    rejected: (err, state, update) =>
      ({
        loading: <span>failed to load</span>,
        saving: <span>failed to save</span>,
      }[state]),
  })
}

export default SignUpToAssignment
