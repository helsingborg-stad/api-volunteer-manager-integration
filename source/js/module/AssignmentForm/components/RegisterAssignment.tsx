import VolunteerServiceContext from '../../../volunteer-service/VolunteerServiceContext'
import { useContext } from 'react'
import PhraseContext from '../../../phrase/PhraseContext'
import AssignmentForm from './assignment/AssignmentForm'

function RegisterAssignment(): JSX.Element {
  const { registerAssignment } = useContext(VolunteerServiceContext)
  const { phrase } = useContext(PhraseContext)

  return (
    <div>
      <AssignmentForm onSubmit={(input) => console.log(input)} />
    </div>
  )
}

export default RegisterAssignment
