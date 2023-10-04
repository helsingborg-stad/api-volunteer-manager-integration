import { useContext } from 'react'
import FormSection from '../../../components/form/FormSection'
import PhraseContext from '../../../phrase/PhraseContextInterface'
import { Field } from '@helsingborg-stad/municipio-react-ui'
import { parseValue } from '../../../util/event'
import Grid from '../../../components/grid/Grid'
import { FieldGroupProps } from './FieldGroupProps'
import { maybeNormalizePhoneNumber } from '../../../util/phone'

export const PublicContactFields = ({
  formState: { publicContact },
  handleChange,
  isLoading,
  isSubmitted,
}: FieldGroupProps) => {
  const { phrase } = useContext(PhraseContext)
  return (
    <FormSection
      sectionTitle={phrase('form_section_label_public_contact', 'Public Contact information')}
      sectionDescription={
        !isSubmitted
          ? phrase(
              'form_section_description_public_contact',
              'Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.',
            )
          : undefined
      }
      isSubSection>
      <Grid col={12} md={6}>
        <Field
          value={publicContact?.email || ''}
          label={phrase('field_label_public_contact_email', 'Public Contact Email')}
          name="assignment_public_contact_email"
          type="email"
          onChange={parseValue(handleChange('publicContact.email'))}
          inputProps={{
            autoComplete: 'on',
            ...(isLoading || isSubmitted ? { disabled: true } : {}),
          }}
          readOnly={isSubmitted}
          placeholder={phrase('field_placeholder_public_contact_email', 'example@email.com')}
        />
      </Grid>

      <Grid col={12} md={6}>
        <Field
          value={publicContact?.phone || ''}
          label={phrase('field_label_public_contact_phone', 'Public Contact Phone')}
          name="assignment_public_contact_phone"
          type="tel"
          onChange={parseValue((v) =>
            maybeNormalizePhoneNumber(v, handleChange('publicContact.phone')),
          )}
          inputProps={{
            autoComplete: 'on',
            ...(isLoading || isSubmitted ? { disabled: true } : {}),
          }}
          readOnly={isSubmitted}
          placeholder={phrase('field_placeholder_public_contact_phone', '042-XX XX XX')}
        />
      </Grid>
    </FormSection>
  )
}

export default PublicContactFields
