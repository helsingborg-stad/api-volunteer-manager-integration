import VolunteerServiceContext from '../../volunteer-service/VolunteerServiceContext'
import { useContext } from 'react'
import AssignmentForm from './components/AssignmentForm'

function RegisterAssignment(): JSX.Element {
  const { registerAssignment } = useContext(VolunteerServiceContext)
  return (
    <div>
      <AssignmentForm onSubmit={registerAssignment} />
    </div>
  )
}

export default RegisterAssignment
