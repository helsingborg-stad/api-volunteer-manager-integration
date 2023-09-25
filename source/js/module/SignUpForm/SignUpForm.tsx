import { Volunteer } from '../../volunteer-service/VolunteerServiceContext'
import PhraseContext from '../../phrase/PhraseContextInterface'
import { PropsWithChildren, useContext } from 'react'
import { Field } from '@helsingborg-stad/municipio-react-ui'
import Grid from '../../components/grid/Grid'

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
    <Grid className="signup-form o-grid--form">
      <Grid col={12}>
        <Field
          name="volunteer_name"
          label={phrase('volunteer_name_field_label', 'Volunteer')}
          value={volunteer.firstName + ' ' + volunteer.lastName}
          onChange={() => {}}
          readOnly
        />
      </Grid>
      <Grid col={12}>
        <Field
          name="employer_name"
          label={phrase('employer_name_field_label', 'Employer')}
          value={'Helsingborg Stad'}
          onChange={() => {}}
          readOnly
        />
      </Grid>
      <div className="o-grid-12 u-margin__bottom--4">{children}</div>
    </Grid>
  )
}

export default SignUpForm
