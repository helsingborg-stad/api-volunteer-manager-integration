import VolunteerServiceContext, {
  Volunteer,
  VOLUNTEER_ERROR,
} from '../../volunteer-service/VolunteerServiceContext'
import useAsync from '../../hooks/UseAsync'
import React, { useContext } from 'react'
import PhraseContext from '../../phrase/PhraseContextInterface'
import { GeneralError } from './rejected/GeneralError'
import { VolunteerNotVerified } from './resolved/VolunteerNotVerified'
import { VolunteerDoesNotExist } from './rejected/VolunteerDoesNotExist'
import { VolunteerCanSubmit } from './resolved/VolunteerCanSubmit'
import { VolunteerHasSubmitted } from './resolved/VolunteerHasSubmitted'
import { Pending } from './pending/Pending'
import { LoaderDots } from '../../components/loader-dots/LoaderDots'

type State = 'loading' | 'saving'
const hasSubmitted = (volunteer: Volunteer, assignmentId: string) =>
  volunteer.assignments?.find((a) => a.assignmentId === parseInt(assignmentId)) !== undefined
const canSubmit = (volunteer: Volunteer, rejectStatus: string[] = ['new', 'denied']) =>
  volunteer.status && !rejectStatus.includes(volunteer.status)

export function SignUpToAssignment({
  assignmentId,
  closeDialog,
  registrationUrl,
}: {
  assignmentId: string
  closeDialog: () => any
  registrationUrl: string
}): JSX.Element {
  const { getVolunteer, applyToAssignment } = useContext(VolunteerServiceContext)
  const { phrase } = useContext(PhraseContext)
  const inspect = useAsync<Volunteer, State>(getVolunteer, 'loading')
  return inspect({
    pending: (state, data) => (
      <LoaderDots
        render={(dots) => (
          <Pending
            volunteer={{
              ...data,
              ...{
                firstName: data?.firstName && data.firstName.length > 0 ? data.firstName : dots,
              },
            }}
            disabledButtonLabel={
              {
                loading: phrase('loading_text', 'Loading'),
                saving: phrase('saving_text', 'Saving'),
              }[state] + dots
            }
            onClickClose={closeDialog}
            logoutButtonLabel={phrase('logout_button_label', 'Logout')}
          />
        )}
      />
    ),
    resolved: (volunteer, state, update) =>
      ({
        saving: (
          <VolunteerHasSubmitted
            volunteer={volunteer}
            signUpButtonLabel={phrase('sign_up_button_label', 'Sign up')}
            onClick={closeDialog}
            logoutButtonLabel={phrase('logout_button_label', 'Logout')}
            noticeText={phrase('after_sign_up_text', 'Thank you for your registration!')}
          />
        ),
        loading: {
          canSubmit: (
            <VolunteerCanSubmit
              volunteer={volunteer}
              onClickSubmit={() =>
                update(applyToAssignment(parseInt(assignmentId)).then(getVolunteer), 'saving')
              }
              signUpButtonLabel={phrase('sign_up_button_label', 'Sign up')}
              onClickClose={closeDialog}
              logoutButtonLabel={phrase('logout_button_label', 'Logout')}
            />
          ),
          notVerified: (
            <VolunteerNotVerified
              volunteer={volunteer}
              signUpButtonLabel={phrase('sign_up_button_label', 'Sign up')}
              onClickClose={closeDialog}
              logoutButtonLabel={phrase('logout_button_label', 'Logout')}
              noticeText={phrase(
                'volunteer_not_approved_text',
                'Your volunteer application is pending.',
              )}
            />
          ),
        }[`${canSubmit(volunteer) ? 'canSubmit' : 'notVerified'}`],
      }[`${hasSubmitted(volunteer, assignmentId) ? 'saving' : state}`]),
    rejected: (err, state, update) =>
      ({
        loading: {
          [VOLUNTEER_ERROR.VOLUNTEER_DOES_NOT_EXIST]: (
            <VolunteerDoesNotExist
              onSubmit={() => {}}
              onClick={closeDialog}
              logoutButtonLabel={phrase('logout_button_label', 'Logout')}
              registerButtonLabel={phrase('registration_button_label', 'Register as a volunteer')}
              noticeText={phrase(
                'volunteer_not_registered_text',
                'You are not registered as a volunteer.',
              )}
              registrationUrl={registrationUrl}
            />
          ),
          error: (
            <GeneralError
              onClickClose={closeDialog}
              buttonLabel={phrase('close_button_label', 'Close')}
              noticeText={phrase('error_text', 'Something went wrong, please try again later.')}
            />
          ),
        }[
          err.name === VOLUNTEER_ERROR.VOLUNTEER_DOES_NOT_EXIST
            ? VOLUNTEER_ERROR.VOLUNTEER_DOES_NOT_EXIST
            : 'error'
        ],
        saving: (
          <GeneralError
            onClickClose={closeDialog}
            buttonLabel={phrase('close_button_label', 'Close')}
            noticeText={phrase('error_text', 'Something went wrong, please try again later.')}
          />
        ),
      }[state]),
  })
}

export default SignUpToAssignment
