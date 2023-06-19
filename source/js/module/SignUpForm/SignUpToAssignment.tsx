import VolunteerServiceContext, { Volunteer } from '../../volunteer-service/VolunteerServiceContext'
import useAsync from '../../hooks/UseAsync'
import { useContext } from 'react'
import SignUpForm from './SignUpForm'
import { CircularProgress } from '@mui/material'
import { Button } from '@helsingborg-stad/municipio-react-ui'

type State = 'loading' | 'saving'

const C2A = (props: { onClick: (e: any) => void; disabled?: boolean }) => (
  <>
    <Button color={'primary'} disabled={props.disabled ?? false} onClick={props.onClick}>
      {'Anmäl intresse'}
    </Button>
    <Button color={'secondary'} disabled={props.disabled ?? false} onClick={props.onClick}>
      {'Avbryt'}
    </Button>
  </>
)

export function SignUpToAssignment({ assignmentId }: { assignmentId: string }): JSX.Element {
  const { getVolunteer, applyToAssignment } = useContext(VolunteerServiceContext)
  const inspect = useAsync<Volunteer, State>(getVolunteer, 'loading')

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
        <Button color={'primary'} disabled>
          {'Laddar'}
        </Button>
      </SignUpForm>
    ),
    resolved: (volunteer, state, update) =>
      volunteer.assignments?.find((a) => a.assignmentId === parseInt(assignmentId)) ? (
        <span>{'Submitted'}</span>
      ) : (
        <SignUpForm volunteer={volunteer} onSubmit={() => null}>
          <C2A
            onClick={() =>
              update(applyToAssignment(parseInt(assignmentId)).then(getVolunteer), 'saving')
            }
          />
        </SignUpForm>
      ),
    rejected: (err, state, update) => <span>rejected</span>,
  })
}

export default SignUpToAssignment
