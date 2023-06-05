import FormSection from '../form/FormSection'
import PhraseContext from '../../../../phrase/PhraseContextInterface'
import { useContext } from 'react'
import { Field } from '@helsingborg-stad/municipio-react-ui'
import { AssignmentInput } from '../../../../volunteer-service/VolunteerServiceContext'

interface Props {
  formState: AssignmentInput
  handleInputChange: (field: string) => any
}

export const GeneralFields = ({ formState, handleInputChange }: Props) => {
  const { phrase } = useContext(PhraseContext)

  return (
    <FormSection
      sectionTitle={phrase('form_section_label_general', 'Register Volunteer Assignment')}
      sectionDescription={phrase(
        'form_section_description_general',
        'Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.',
      )}>
      <div className="o-grid-12">
        <Field
          value={formState.title}
          label={phrase('field_label_general_title', 'Name of the assignment')}
          name="assignment_title"
          type="text"
          onChange={handleInputChange('title')}
          required
        />
      </div>

      <div className="o-grid-12 o-grid-6@md">
        <Field
          value={formState.employer.contacts[0].name}
          label={phrase('field_label_general_contact_name', 'Name')}
          name="contact_name"
          type="text"
          onChange={handleInputChange('employer.contacts.0.name')}
          required
        />
      </div>

      <div className="o-grid-12 o-grid-6@md">
        <Field
          value={formState.employer.name}
          label={phrase('field_label_general_organisation', 'Organisation')}
          name="organisation_name"
          type="text"
          onChange={handleInputChange('employer.name')}
          required
        />
      </div>

      <div className="o-grid-12 o-grid-6@md">
        <Field
          value={formState.employer.contacts[0].email}
          label={phrase('field_label_general_contact_email', 'E-mail')}
          name="contact_email"
          type="email"
          onChange={handleInputChange('employer.contacts.0.email')}
          required
        />
      </div>
      <div className="o-grid-12 o-grid-6@md">
        <Field
          value={formState.employer.contacts[0].phone}
          label={phrase('field_label_general_contact_phone', 'Phone')}
          name="contact_phone"
          type="tel"
          onChange={handleInputChange('employer.contacts.0.phone')}
          required
        />
      </div>
    </FormSection>
  )
}

export default GeneralFields
