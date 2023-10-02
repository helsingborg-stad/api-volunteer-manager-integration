import { Volunteer } from '../../volunteer-service/VolunteerServiceContext'
import PhraseContext from '../../phrase/PhraseContextInterface'
import { PropsWithChildren, useContext } from 'react'
import { Typography } from '@helsingborg-stad/municipio-react-ui'

interface SignUpFormProps extends PropsWithChildren {
  volunteer: Volunteer
  onSubmit?: () => any
  isLoading?: boolean
  isSubmitted?: boolean
  hasError?: boolean
  message?: string
}

function SignUpForm({ volunteer, onSubmit = () => {}, children }: SignUpFormProps): JSX.Element {
  const { phrase } = useContext(PhraseContext)
  return (
    <div>
      <div
        style={{
          position: 'absolute',
          top: '32px',
          left: '24px',
        }}>
        <Typography variant="meta">
          {phrase('logged_in_as', 'Logged in as') + ': '}
          <b>
            {volunteer.firstName} {volunteer.lastName}
          </b>
        </Typography>
      </div>
      <div>{children}</div>
    </div>
  )
}

export default SignUpForm
