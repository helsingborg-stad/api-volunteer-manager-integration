import { useContext } from 'react'
import FormSection from '../../../components/form/FormSection'
import PhraseContext from '../../../phrase/PhraseContextInterface'
import { parseValue, reportValidity } from '../../../util/event'
import { Field, Textarea } from '@helsingborg-stad/municipio-react-ui'
import { FieldGroupProps } from './FieldGroupProps'
import Grid from '../../../components/grid/Grid'

export const DetailsFields = ({
  formState: {
    description,
    benefits,
    qualifications,
    totalSpots,
    schedule = '',
    endDate = '',
    location = {
      address: '',
      city: '',
      postal: '',
    },
  },
  handleChange,
  isLoading,
  isSubmitted,
}: FieldGroupProps) => {
  const { phrase } = useContext(PhraseContext)

  return (
    <FormSection
      sectionTitle={phrase('form_section_label_details', 'Assignment information')}
      sectionDescription={
        !isSubmitted
          ? phrase(
              'form_section_description_details',
              'Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.',
            )
          : undefined
      }
      isSubSection>
      <Grid col={12}>
        <Textarea
          value={description}
          label={phrase('field_label_details_description', 'Description')}
          name="assignment_description"
          onChange={parseValue(handleChange('description'))}
          onBlur={reportValidity}
          rows={10}
          required
          textareaProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </Grid>
      <Grid col={12}>
        <Textarea
          value={benefits}
          label={phrase('field_label_details_benefits', 'Benefits')}
          name="assignment_benefits"
          onChange={parseValue(handleChange('benefits'))}
          rows={10}
          textareaProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </Grid>
      <Grid col={12}>
        <Textarea
          value={qualifications}
          label={phrase('field_label_details_qualifications', 'Qualifications')}
          name="assignment_qualifications"
          onChange={parseValue(handleChange('qualifications'))}
          rows={10}
          textareaProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </Grid>
      <Grid col={12}>
        <Textarea
          value={schedule}
          label={phrase('field_label_details_when_and_where', 'When and where?')}
          name="assignment_when_and_where"
          onChange={parseValue(handleChange('schedule'))}
          rows={4}
          textareaProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </Grid>
      <Grid col={12}>
        <Field
          value={totalSpots?.toString() ?? ''}
          label={phrase('field_label_spots', 'Total spots')}
          name="assignment_total_spots"
          type={!isSubmitted ? 'number' : 'text'}
          onChange={parseValue(handleChange('totalSpots'))}
          inputProps={
            !isSubmitted
              ? {
                  min: 0,
                  onKeyPress: (e) => !/[0-9]/.test(e.key) && e.preventDefault(),
                  ...(isLoading ? { disabled: true } : {}),
                }
              : { disabled: true }
          }
          readOnly={isSubmitted}
        />
      </Grid>
      <Grid col={12}>
        <Field
          value={location?.address || ''}
          label={phrase('field_label_assignment_location_address', 'Address')}
          name="assignment_location_address"
          type="text"
          onChange={parseValue(handleChange('location.address'))}
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </Grid>
      <Grid col={12} md={6}>
        <Field
          value={location?.postal || ''}
          label={phrase('field_label_assignment_location_postal', 'Postal')}
          name="assignment_location_postal"
          type="number"
          onChange={parseValue(handleChange('location.postal'))}
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </Grid>
      <Grid col={12} md={6}>
        <Field
          value={location?.city || ''}
          label={phrase('field_label_assignment_location_city', 'City')}
          name="assignment_location_city"
          type="text"
          onChange={parseValue(handleChange('location.city'))}
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </Grid>
      <Grid col={12} >
        <Field
          value={endDate || ''}
          label={phrase('field_label_assignment_end_date', 'End date')}
          name="assignment_end_date"
          type="date"
          onChange={parseValue(handleChange('endDate'))}
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </Grid>
    </FormSection>
  )
}

export default DetailsFields
