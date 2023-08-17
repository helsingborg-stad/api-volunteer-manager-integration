import FormSection from '../../../../components/form/FormSection'
import PhraseContext from '../../../../phrase/PhraseContextInterface'
import { useContext } from 'react'
import { Field } from '@helsingborg-stad/municipio-react-ui'
import { FieldGroupProps } from './FieldGroupProps'
import ImagePicker from '../../../../components/form/ImagePicker'
import { parseValue } from '../../../../util/event'

export const GeneralFields = ({
  formState,
  handleChange,
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
          onChange={parseValue(handleChange('image'))}
          required
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>

      <div className="o-grid-12">
        <ImagePicker
          label={phrase('field_label_assignment_image', 'Assignment Image')}
          name="assignment_image"
          onChange={handleChange('image')}
          value={formState.image}
          required
        />
      </div>

      <div className="o-grid-12 o-grid-6@md">
        <Field
          value={formState.employer.contacts[0].name}
          label={phrase('field_label_general_contact_name', 'Name')}
          name="contact_name"
          type="text"
          onChange={parseValue(handleChange('employer.contacts.0.name'))}
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
          onChange={parseValue(handleChange('employer.name'))}
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
          onChange={parseValue(handleChange('employer.contacts.0.email'))}
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
          onChange={parseValue(handleChange('employer.contacts.0.phone'))}
          required
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>
    </FormSection>
  )
}

export default GeneralFields
