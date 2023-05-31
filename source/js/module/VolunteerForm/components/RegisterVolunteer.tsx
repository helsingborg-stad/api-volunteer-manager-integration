import VolunteerServiceContext, {
  Volunteer,
} from '../../../volunteer-service/VolunteerServiceContext'
import { useContext } from 'react'
import useAsync from '../../../hooks/UseAsync'
import VolunteerForm from './volunteer/VolunteerForm'

type State = 'loading' | 'saving'

function RegisterVolunteer(): JSX.Element {
  const { getVolunteer, registerVolunteer } = useContext(VolunteerServiceContext)

  const inspect = useAsync<Volunteer, State>(getVolunteer, 'loading')

  return inspect({
    pending: (state) => <span>pending</span>,
    resolved: (volunteer, state, update) => (
      <div>
        <VolunteerForm
          volunteer={volunteer}
          onSubmit={(input) => update(registerVolunteer(input), 'saving')}
        />
      </div>
    ),
    rejected: (err, state, update) => <span>rejected</span>,
  })
}

export default RegisterVolunteer
