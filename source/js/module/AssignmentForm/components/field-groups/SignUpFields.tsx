import FormSection from '../../../../components/form/FormSection'
import PhraseContext from '../../../../phrase/PhraseContextInterface'
import { useContext } from 'react'
import { Field, Select } from '@helsingborg-stad/municipio-react-ui'
import {
  SignUpTypes,
  SignUpWithContact,
  SignUpWithWebsite,
} from '../../../../volunteer-service/VolunteerServiceContext'

import { FieldGroupProps } from './FieldGroupProps'
import Grid from '../../../../components/grid/Grid'
import ShowIf from '../../../../util/ShowIf'

export function hasProperty<T>(data: any, property: string): data is T {
  return data && data[property] !== undefined
}

export const SignUpFields = ({
  formState,
  handleInputChange,
  isLoading,
  isSubmitted,
}: FieldGroupProps) => {
  const { phrase } = useContext(PhraseContext)

  return (
    <FormSection
      sectionTitle={phrase('form_section_label_signup', 'Sign up information')}
      sectionDescription={
        !isSubmitted
          ? phrase(
              'form_section_description_signup',
              'Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.',
            )
          : undefined
      }
      isSubSection>
      <Grid>
        <Select
          options={[
            [SignUpTypes.Link, phrase('field_option_label_signup_type_link', 'Sign up Link')],
            [SignUpTypes.Contact, phrase('field_option_label_signup_contact', 'Sign up Contact')],
            [
              SignUpTypes.Internal,
              phrase('field_option_label_signup_contact', 'Internal assignment'),
            ],
          ]}
          value={formState.signUp.type ?? ''}
          label={phrase('field_label_signup_signup_type', 'SignUp Type')}
          name="signup_type"
          onChange={handleInputChange('signUp.type')}
          required
          selectProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </Grid>
      {
        {
          [SignUpTypes.Link]: hasProperty<SignUpWithWebsite>(formState.signUp, 'type') && (
            <Grid>
              <Field
                value={formState.signUp.link ?? ''}
                label={phrase('field_label_signup_link', 'Sign up link')}
                name="signup_link"
                required
                type="url"
                onChange={handleInputChange('signUp.link')}
                inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
                readOnly={isSubmitted}
              />
            </Grid>
          ),
          [SignUpTypes.Contact]: hasProperty<SignUpWithContact>(formState.signUp, 'type') && (
            <Grid container className="o-grid--form">
              <Grid>
                <Field
                  value={formState.signUp.name}
                  label={phrase('field_label_signup_name', 'Sign up Contact Name')}
                  name="signup_name"
                  type={'text'}
                  onChange={handleInputChange('signUp.name')}
                  inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
                  readOnly={isSubmitted}
                />
              </Grid>
              <Grid md={6}>
                <Field
                  value={formState.signUp.email}
                  label={phrase('field_label_signup_email', 'Email for Sign up')}
                  name="signup_email"
                  required={
                    formState.signUp.phone && formState.signUp.phone.length > 0 ? undefined : true
                  }
                  type="email"
                  onChange={handleInputChange('signUp.email')}
                  inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
                  readOnly={isSubmitted}
                />
              </Grid>
              <Grid md={6}>
                <Field
                  value={formState.signUp.phone}
                  label={phrase('field_label_signup_phone', 'Phone number for Sign up')}
                  name="signup_phone"
                  required={
                    formState.signUp.email && formState.signUp.email.length > 0 ? undefined : true
                  }
                  type="tel"
                  onChange={handleInputChange('signUp.phone')}
                  inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
                  readOnly={isSubmitted}
                />
              </Grid>
            </Grid>
          ),
          [SignUpTypes.Internal]: null,
          ['null']: null,
        }[formState.signUp.type ?? 'null']
      }
      <Grid>
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
          selectProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </Grid>
      <ShowIf condition={formState?.signUp?.hasDeadline === 'yes'}>
        <Grid>
          <Field
            value={formState.signUp.deadline ?? ''}
            label={phrase('field_label_signup_due_date', 'Last date to apply')}
            name="signup_due_date"
            type="date"
            onChange={handleInputChange('signUp.deadline')}
            required
            inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
            readOnly={isSubmitted}
          />
        </Grid>
      </ShowIf>
    </FormSection>
  )
}

export default SignUpFields
