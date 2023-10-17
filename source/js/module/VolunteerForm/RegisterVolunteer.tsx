import VolunteerServiceContext, {
  Volunteer,
  VOLUNTEER_ERROR,
} from '../../volunteer-service/VolunteerServiceContext'
import { useCallback, useContext } from 'react'
import useAsync from '../../hooks/UseAsync'
import VolunteerForm from './VolunteerForm'
import useForm from '../../hooks/UseForm'
import PhraseContext from '../../phrase/PhraseContextInterface'
import { capitalizeName } from '../../util/capitalize'

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
    formState: { phone, email, newsletter },
    handleChange,
  } = useForm<Volunteer>({
    initialState: volunteer,
  })

  return inspect({
    pending: (state) =>
      ({
        loading: () => <span>Loading</span>,
        saving: () => (
          <VolunteerForm
            handleChange={handleChange}
            volunteer={{ ...volunteer, ...{ phone, email, newsletter } }}
            onSubmit={(input) => null}
            isLoading
          />
        ),
      }[state]()),
    resolved: (volunteerData, state, update) =>
      ({
        showForm: () => (
          <VolunteerForm
            handleChange={handleChange}
            volunteer={{ ...volunteerData, ...{ phone, email, newsletter } }}
            onSubmit={(input) => update(register(input), 'saving')}
          />
        ),
        isSubmitted: () => (
          <VolunteerForm
            handleChange={handleChange}
            volunteer={{ ...volunteerData, ...{ phone, email, newsletter } }}
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
        handleChange={handleChange}
        volunteer={{ ...volunteer, ...{ phone, email, newsletter } }}
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
        const { name } = e
        if (!name || name !== VOLUNTEER_ERROR.VOLUNTEER_DOES_NOT_EXIST) throw e
        return window.gdiHost.getAccessToken().then(({ decoded }) => ({
          id: decoded.id,
          firstName: capitalizeName(decoded.firstName),
          lastName: capitalizeName(decoded.lastName),
          email: '',
          phone: '',
          status: '',
          newsletter: undefined,
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
