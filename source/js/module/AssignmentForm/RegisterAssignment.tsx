import VolunteerServiceContext from '../../volunteer-service/VolunteerServiceContext'
import { useContext } from 'react'
import AssignmentForm from './components/AssignmentForm'

function RegisterAssignment(): JSX.Element {
  const { registerAssignment } = useContext(VolunteerServiceContext)
  return <AssignmentForm onSubmit={registerAssignment} />
}

export default RegisterAssignment
