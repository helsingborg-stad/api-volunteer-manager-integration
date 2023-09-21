import { Volunteer } from '../../volunteer-service/VolunteerServiceContext'
import PhraseContext from '../../phrase/PhraseContextInterface'
import { PropsWithChildren, useContext } from 'react'
import { Field } from '@helsingborg-stad/municipio-react-ui'

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
    <div className="signup-form o-grid o-grid--form">
      <div className="o-grid-12">
        <Field
          name="volunteer_name"
          label={phrase('volunteer_name_field_label', 'Volunteer')}
          value={volunteer.firstName + ' ' + volunteer.lastName}
          onChange={() => {}}
          readOnly
        />
      </div>
      <div className="o-grid-12">
        <Field
          name="employer_name"
          label={phrase('employer_name_field_label', 'Employer')}
          value={'Helsingborg Stad'}
          onChange={() => {}}
          readOnly
        />
      </div>
      <div className="o-grid-12 u-margin__bottom--4">{children}</div>
    </div>
  )
}

export default SignUpForm
