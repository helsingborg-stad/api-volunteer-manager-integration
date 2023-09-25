import { useContext } from 'react'
import FormSection from '../../../components/form/FormSection'
import PhraseContext from '../../../phrase/PhraseContextInterface'
import { Field, Select } from '@helsingborg-stad/municipio-react-ui'
import { SignUpTypes, SignUpWithWebsite } from '../../../volunteer-service/VolunteerServiceContext'
import { parseValue } from '../../../util/event'
import Grid from '../../../components/grid/Grid'
import ShowIf from '../../../util/ShowIf'
import { FieldGroupProps } from './FieldGroupProps'

export function hasProperty<T>(data: any, property: string): data is T {
  return data && data[property] !== undefined
}

export const SignUpFields = ({
  formState,
  handleChange,
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
              phrase('field_option_label_signup_internal', 'Internal assignment'),
            ],
          ]}
          value={formState.signUp.type ?? ''}
          label={phrase('field_label_signup_signup_type', 'SignUp Type')}
          name="signup_type"
          onChange={parseValue(handleChange('signUp.type'))}
          required
          placeholder={phrase('select_placeholder', 'Select an option')}
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
                onChange={parseValue(handleChange('signUp.link'))}
                inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
                readOnly={isSubmitted}
              />
            </Grid>
          ),
          [SignUpTypes.Contact]: null,
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
          onChange={parseValue(handleChange('signUp.hasDeadline'))}
          required
          placeholder={phrase('select_placeholder', 'Select an option')}
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
            onChange={parseValue(handleChange('signUp.deadline'))}
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
