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

  return (
    <FormSection
      sectionTitle={phrase('form_section_label_signup', 'Sign up information')}
      sectionDescription={phrase(
        'form_section_description_signup',
        'Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.',
      )}
      isSubSection>
      <div className="o-grid-12">
        <Select
          options={[
            ['link', phrase('field_option_label_signup_type_link', 'Sign up Link')],
            ['contact', phrase('field_option_label_signup_contact', 'Sign up Contact')],
          ]}
          value={formState.signUp.type ?? ''}
          label={phrase('field_label_signup_signup_type', 'SignUp Type')}
          name="signup_type"
          onChange={handleInputChange('signUp.type')}
          required
        />
      </div>

      {formState.signUp.type === SignUpTypes.Link ? (
        <div className="o-grid-12">
          <Field
            value={formState.signUp.link ?? ''}
            label={phrase('field_label_signup_link', 'Sign up link')}
            name="signup_email"
            required
            type="url"
            onChange={handleInputChange('signUp.link')}
          />
        </div>
      ) : null}

      {formState.signUp.type === SignUpTypes.Contact ? (
        <div className="o-grid o-grid--form">
          <div className="o-grid-12">
            <Field
              value={formState.signUp.name}
              label={phrase('field_label_signup_name', 'Sign up Contact Name')}
              name="signup_name"
              type={'text'}
              onChange={handleInputChange('signUp.name')}
            />
          </div>
          <div className="o-grid-12 o-grid-6@md">
            <Field
              value={formState.signUp.email}
              label={phrase('field_label_signup_email', 'Email for Sign up')}
              name="signup_email"
              required={
                formState.signUp.phone && formState.signUp.phone.length > 0 ? undefined : true
              }
              type="email"
              onChange={handleInputChange('signUp.email')}
            />
          </div>
          <div className="o-grid-12 o-grid-6@md">
            <Field
              value={formState.signUp.phone}
              label={phrase('field_label_signup_phone', 'Phone number for Sign up')}
              name="signup_phone"
              required={
                formState.signUp.email && formState.signUp.email.length > 0 ? undefined : true
              }
              type="tel"
              onChange={handleInputChange('signUp.phone')}
            />
          </div>
        </div>
      ) : null}

      <div className="o-grid-12">
        <Select
          options={[
            ['no', phrase('field_option_label_signup_has_due_date_no', 'No')],
            ['yes', phrase('field_option_label_signup_has_due_date_yes', 'Yes')],
          ]}
          value={formState.signUp.hasDeadline ?? ''}
          label={phrase(
            'field_label_signup_has_due_date',
            'Is there a specific due date for signing up?',
          )}
          name="signup_has_due_date"
          onChange={handleInputChange('signUp.hasDeadline')}
          required
        />
      </div>

      {formState.signUp.hasDeadline === 'yes' ? (
        <div className="o-grid-12">
          <Field
            value={formState.signUp.deadline ?? ''}
            label={phrase('field_label_signup_due_date', 'Last date to apply')}
            name="signup_due_date"
            type="date"
            onChange={handleInputChange('signUp.deadline')}
          />
        </div>
      ) : null}
    </FormSection>
  )
}

export default SignUpFields
