import FormSection from '../form/FormSection'
import PhraseContext from '../../../../phrase/PhraseContext'
import { useContext } from 'react'
import { Field } from '@helsingborg-stad/municipio-react-ui'
import { AssignmentInput } from '../../../../volunteer-service/VolunteerServiceContext'

interface Props {
  formState: AssignmentInput
  handleInputChange: <T>(field: string) => any
}

export const PublicContactFields = ({ formState: { publicContact }, handleInputChange }: Props) => {
  const { phrase } = useContext(PhraseContext)

  return (
    <FormSection
      sectionTitle={phrase('form_section_label_public_contact', 'Public Contact information')}
      sectionDescription={phrase(
        'form_section_description_public_contact',
        'Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.',
      )}
      isSubSection>
      <div className="o-grid-12 o-grid-12@md">
        <Field
          value={publicContact?.name || ''}
          label={phrase('field_label_public_contact_name', 'Public Contact Name')}
          name="assignment_public_contact_name"
          type="text"
          onChange={handleInputChange('publicContact.name')}
        />
      </div>

      <div className="o-grid-12 o-grid-6@md">
        <Field
          value={publicContact?.email || ''}
          label={phrase('field_label_public_contact_email', 'Public Contact Email')}
          name="assignment_public_contact_email"
          type="email"
          onChange={handleInputChange('publicContact.email')}
        />
      </div>

      <div className="o-grid-12 o-grid-6@md">
        <Field
          value={publicContact?.phone || ''}
          label={phrase('field_label_public_contact_phone', 'Public Contact Phone')}
          name="assignment_public_contact_phone"
          type="tel"
          onChange={handleInputChange('publicContact.phone')}
        />
      </div>
    </FormSection>
  )
}

export default PublicContactFields
