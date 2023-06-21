import FormSection from '../../../../components/form/FormSection'
import PhraseContext from '../../../../phrase/PhraseContextInterface'
import { useContext } from 'react'
import { Field } from '@helsingborg-stad/municipio-react-ui'
import { FieldGroupProps } from './FieldGroupProps'

export const GeneralFields = ({
  formState,
  handleInputChange,
  isLoading,
  isSubmitted,
}: FieldGroupProps) => {
  const { phrase } = useContext(PhraseContext)

  return (
    <FormSection
      sectionTitle={phrase('form_section_label_general', 'Register Volunteer Assignment')}
      isSubSection={isSubmitted}
      sectionDescription={
        !isSubmitted
          ? phrase(
              'form_section_description_general',
              'Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.',
            )
          : undefined
      }>
      <div className="o-grid-12">
        <Field
          value={formState.title}
          label={phrase('field_label_general_title', 'Name of the assignment')}
          name="assignment_title"
          type="text"
          onChange={handleInputChange('title')}
          required
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>

      <div className="o-grid-12">
        <Field
          label={phrase('field_label_assignment_image', 'Assignment Image')}
          name="assignment_image"
          type="file"
          onChange={handleInputChange('image')}
          required
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
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
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
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
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
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
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
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
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>
    </FormSection>
  )
}

export default GeneralFields
