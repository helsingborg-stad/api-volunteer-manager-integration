import FormSection from '../../../../components/form/FormSection'
import PhraseContext from '../../../../phrase/PhraseContextInterface'
import { useContext } from 'react'
import { Field } from '@helsingborg-stad/municipio-react-ui'

import { FieldGroupProps } from './FieldGroupProps'

import { parseValue } from '../../../../util/event'

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
      <div className="o-grid-12 o-grid-6@md">
        <Field
          value={publicContact?.email || ''}
          label={phrase('field_label_public_contact_email', 'Public Contact Email')}
          name="assignment_public_contact_email"
          type="email"
          onChange={parseValue(handleChange('publicContact.email'))}
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>

      <div className="o-grid-12 o-grid-6@md">
        <Field
          value={publicContact?.phone || ''}
          label={phrase('field_label_public_contact_phone', 'Public Contact Phone')}
          name="assignment_public_contact_phone"
          type="tel"
          onChange={parseValue(handleChange('publicContact.phone'))}
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>
    </FormSection>
  )
}

export default PublicContactFields
