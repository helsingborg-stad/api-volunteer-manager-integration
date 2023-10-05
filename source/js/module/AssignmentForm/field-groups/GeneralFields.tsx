import { useContext } from 'react'
import FormSection from '../../../components/form/FormSection'
import PhraseContext from '../../../phrase/PhraseContextInterface'
import { Field } from '@helsingborg-stad/municipio-react-ui'
import ImagePicker from '../../../components/form/ImagePicker'
import { composeEventFns, parseValue, reportValidity, setValidity } from '../../../util/event'
import Grid from '../../../components/grid/Grid'
import { FieldGroupProps } from './FieldGroupProps'
import { tryFormatPhoneNumber, validatePhoneNumber } from '../../../util/phone'

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
      <Grid col={12}>
        <Field
          value={formState.title}
          label={phrase('field_label_general_title', 'Name of the assignment')}
          name="assignment_title"
          type="text"
          onChange={parseValue(handleChange('title'))}
          onBlur={reportValidity}
          required
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </Grid>

      <Grid col={12}>
        <ImagePicker
          label={phrase('field_label_assignment_image', 'Assignment Image')}
          name="assignment_image"
          onChange={handleChange('image')}
          value={formState.image}
          required
          readOnly={isSubmitted}
          disabled={isSubmitted || isLoading}
        />
      </Grid>

      <Grid col={12} md={6}>
        <Field
          value={formState.employer.contacts[0].name}
          label={phrase('field_label_general_contact_name', 'Name')}
          name="contact_name"
          type="text"
          onChange={parseValue(handleChange('employer.contacts.0.name'))}
          onBlur={reportValidity}
          required
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
          helperText={phrase('field_helper_general_contact_phone', '')}
        />
      </Grid>

      <Grid col={12} md={6}>
        <Field
          value={formState.employer.name}
          label={phrase('field_label_general_organisation', 'Organisation')}
          name="organisation_name"
          type="text"
          onChange={parseValue(handleChange('employer.name'))}
          onBlur={reportValidity}
          required
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </Grid>

      <Grid col={12} md={6}>
        <Field
          value={formState.employer.contacts[0].email}
          label={phrase('field_label_general_contact_email', 'E-mail')}
          name="contact_email"
          type="email"
          onChange={parseValue(handleChange('employer.contacts.0.email'))}
          onBlur={reportValidity}
          required
          inputProps={{
            autoComplete: 'on',
            ...(isLoading || isSubmitted ? { disabled: true } : {}),
          }}
          readOnly={isSubmitted}
          helperText={phrase('field_helper_general_contact_email', '')}
          placeholder={phrase('field_placeholder_general_contact_email', 'example@email.com')}
        />
      </Grid>
      <Grid col={12} md={6}>
        <Field
          value={formState.employer.contacts[0].phone}
          label={phrase('field_label_general_contact_phone', 'Phone')}
          name="contact_phone"
          type="tel"
          onChange={composeEventFns([
            setValidity(validatePhoneNumber),
            parseValue(tryFormatPhoneNumber(handleChange('employer.contacts.0.phone'))),
          ])}
          onBlur={reportValidity}
          required
          inputProps={{
            autoComplete: 'on',
            ...(isLoading || isSubmitted ? { disabled: true } : {}),
          }}
          readOnly={isSubmitted}
          helperText={phrase('field_helper_general_contact_phone', '')}
          placeholder={phrase('field_placeholder_general_contact_phone', '042-XX XX XX')}
        />
      </Grid>
    </FormSection>
  )
}

export default GeneralFields
