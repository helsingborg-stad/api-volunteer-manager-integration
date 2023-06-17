import VolunteerServiceContext, {
  Volunteer,
} from '../../../volunteer-service/VolunteerServiceContext'
import { useCallback, useContext } from 'react'
import useAsync from '../../../hooks/UseAsync'
import VolunteerForm from './volunteer/VolunteerForm'
import useForm from '../../../hooks/UseForm'
import PhraseContext from '../../../phrase/PhraseContextInterface'

type State = 'loading' | 'saving'

const AsyncForm = ({ volunteer }: { volunteer: Volunteer }) => {
  const { phrase } = useContext(PhraseContext)
  const { registerVolunteer } = useContext(VolunteerServiceContext)

  const register = (i: Volunteer) =>
    registerVolunteer(i).catch((e) => {
      throw new Error(e?.response?.data?.message ?? e.message)
    })

  const inspect = useAsync<Volunteer, State>(async () => volunteer, 'loading')

  const {
    formState: { phone, email },
    handleInputChange,
  } = useForm<Volunteer>({
    initialState: volunteer,
  })

  return inspect({
    pending: (state) =>
      ({
        loading: () => <span>Loading</span>,
        saving: () => (
          <VolunteerForm
            handleInputChange={handleInputChange}
            volunteer={{ ...volunteer, ...{ phone, email } }}
            onSubmit={(input) => null}
            isLoading
          />
        ),
      }[state]()),
    resolved: (volunteerData, state, update) =>
      ({
        showForm: () => (
          <VolunteerForm
            handleInputChange={handleInputChange}
            volunteer={{ ...volunteerData, ...{ phone, email } }}
            onSubmit={(input) => update(register(input), 'saving')}
          />
        ),
        isSubmitted: () => (
          <VolunteerForm
            handleInputChange={handleInputChange}
            volunteer={{ ...volunteerData, ...{ phone, email } }}
            onSubmit={(input) => update(register(input), 'saving')}
            isSubmitted
            message={phrase(
              'successful_submission_message',
              'Successfully submitted new volunteer!',
            )}
          />
        ),
      }[
        volunteerData?.status?.length && volunteerData.status.length > 0
          ? 'isSubmitted'
          : 'showForm'
      ]()),
    rejected: (err, state, update) => (
      <VolunteerForm
        handleInputChange={handleInputChange}
        volunteer={{ ...volunteer, ...{ phone, email } }}
        onSubmit={(input) => update(register(input), 'saving')}
        hasError
        message={err.message}
      />
    ),
  })
}

function RegisterVolunteer(): JSX.Element {
  const { getVolunteer, registerVolunteer } = useContext(VolunteerServiceContext)

  const getVolunteerWithNullCatch = useCallback(
    async (): Promise<Volunteer> =>
      getVolunteer().catch((e) => {
        const { response } = e
        if (!response?.data?.message || response.data?.message !== 'Invalid post ID.') {
          throw e
        }
        return window.gdiHost.getAccessToken().then(({ decoded }) => ({
          id: decoded.id,
          firstName: decoded.firstName,
          lastName: decoded.lastName,
          email: '',
          phone: '',
          status: '',
        }))
      }),
    [],
  )

  const inspect = useAsync<Volunteer, State>(getVolunteerWithNullCatch, 'loading')

  return inspect({
    pending: (state) => <span>pending</span>,
    resolved: (volunteer, state, update) => <AsyncForm volunteer={volunteer} />,
    rejected: (err, state, update) => <span>rejected</span>,
  })
}

export default RegisterVolunteer
