import VolunteerServiceContext, {
  Volunteer,
} from '../../../volunteer-service/VolunteerServiceContext'
import { useContext } from 'react'
import PhraseContext from '../../../phrase/PhraseContext'
import useAsync from '../../../util/UseAsync'
import VolunteerForm from './volunteer/VolunteerForm'

type State = 'loading' | 'saving'

function RegisterVolunteer(): JSX.Element {
  const { getVolunteer, registerVolunteer } = useContext(VolunteerServiceContext)
  const { phrase } = useContext(PhraseContext)

  const inspect = useAsync<Volunteer, State>(getVolunteer)

  return inspect({
    pending: (state) => <span>pending</span>,
    resolved: (data, state, update) => (
      <div>
        <span>resolved</span>
        <VolunteerForm />
      </div>
    ),
    rejected: (err, state, update) => <span>rejected</span>,
  })
}

export default RegisterVolunteer
