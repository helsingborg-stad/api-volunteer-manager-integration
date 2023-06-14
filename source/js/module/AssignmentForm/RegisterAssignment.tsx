import VolunteerServiceContext, {
  Assignment,
} from '../../volunteer-service/VolunteerServiceContext'
import { useContext } from 'react'
import AssignmentForm from './components/AssignmentForm'
import useAsync from '../../hooks/UseAsync'
import useForm from '../../hooks/UseForm'

type State = 'loading' | 'saving'

function RegisterAssignment(): JSX.Element {
  const { registerAssignment } = useContext(VolunteerServiceContext)

  const { formState, handleInputChange } = useForm<Assignment>({
    initialState: {
      id: null,
      title: '',
      description: '',
      employer: {
        name: '',
        website: '',
        contacts: [
          {
            name: '',
            email: '',
          },
        ],
      },
      signUp: {
        type: undefined,
        link: '',
        phone: '',
        email: '',
        deadline: undefined,
        hasDeadline: '',
      },
      location: {
        address: '',
        postal: '',
        city: '',
      },
    },
  })

  const inspect = useAsync<Assignment>(async () => formState, 'loading')

  return inspect({
    pending: (state: State, assignment) => (
      <AssignmentForm
        onSubmit={(i) => null}
        handleInputChange={handleInputChange}
        formState={formState}
        isLoading={true}
      />
    ),
    resolved: (assignment: Assignment, state, update) => (
      <AssignmentForm
        handleInputChange={handleInputChange}
        onSubmit={(input) => update(registerAssignment(input), 'saving')}
        formState={assignment?.id && typeof assignment?.id === 'number' ? assignment : formState}
        isSubmitted={assignment?.id && typeof assignment?.id === 'number' ? true : undefined}
      />
    ),
    rejected: (err, state, update, assignment) => (
      <AssignmentForm
        handleInputChange={handleInputChange}
        formState={formState}
        onSubmit={(input) => update(registerAssignment(input), 'saving')}
        errorMessage={err.message}
      />
    ),
  })
}

export default RegisterAssignment
