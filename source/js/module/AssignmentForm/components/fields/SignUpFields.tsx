import FormSection from '../form/FormSection'
import PhraseContext from '../../../../phrase/PhraseContext'
import { useContext } from 'react'
import { Field, Select } from '@helsingborg-stad/municipio-react-ui'
import { AssignmentInput, SignUpTypes } from '../../../../volunteer-service/VolunteerServiceContext'

interface Props {
  formState: AssignmentInput
  handleInputChange: <T>(field: string) => any
}

export const SignUpFields = ({ formState, handleInputChange }: Props) => {
  const { phrase } = useContext(PhraseContext)

  const getField = (inputType: SignUpTypes, label: string, name: string) =>
    formState.signUp.type === inputType ? (
      <div className="o-grid-12">
        <Field
          value={formState.signUp[inputType.toLowerCase() as keyof typeof formState.signUp]}
          label={label}
          name={name}
          type="text"
          onChange={handleInputChange(`signUp.${inputType.toLowerCase()}`)}
        />
      </div>
    ) : null

  const SignUpFields = (
    <>
      <div className="o-grid-12">
        <Select
          options={[
            ['link', 'Sign up Link'],
            ['email', 'E-mail'],
            ['phone', 'Phone'],
          ]}
          value={formState.signUp.type ?? ''}
          label={phrase('field_label_signup_signup_type', 'SignUp Type')}
          name="signup_type"
          onChange={handleInputChange('signUp.type')}
          required
        />
      </div>

      {getField(
        SignUpTypes.Link,
        phrase('field_label_signup_phone', 'Sign Up Link'),
        'signup_link',
      )}
      {getField(
        SignUpTypes.Phone,
        phrase('field_label_signup_phone', 'Sign Up Phone'),
        'signup_phone',
      )}
      {getField(
        SignUpTypes.Email,
        phrase('field_label_signup_email', 'Sign Up Email'),
        'signup_email',
      )}

      <div className="o-grid-12">
        <Field
          value={formState.signUp?.deadline ?? ''}
          label={phrase('field_label_signup_due_date', 'Last date to apply (optional)')}
          name="signup_email"
          type="date"
          onChange={handleInputChange('signUp.deadline')}
          helperText={phrase('field_helper_signup_due_date', 'Leave empty to keep signup open')}
        />
      </div>
    </>
  )

  return (
    <FormSection
      sectionTitle={phrase('form_section_label_signup', 'Sign up information')}
      sectionDescription={phrase(
        'form_section_description_signup',
        'Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.',
      )}
      isSubSection>
      {SignUpFields}
    </FormSection>
  )
}

export default SignUpFields
