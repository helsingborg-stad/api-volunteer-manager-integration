import FormSection from '../../../../components/form/FormSection'
import PhraseContext from '../../../../phrase/PhraseContextInterface'
import { useContext } from 'react'
import { Field, Textarea } from '@helsingborg-stad/municipio-react-ui'

import { FieldGroupProps } from './FieldGroupProps'

export const DetailsFields = ({
  formState: {
    description,
    benefits,
    qualifications,
    where = '',
    when = '',
    readMoreLink = '',
    totalSpots,
    schedule = '',
    location = {
      address: '',
      city: '',
      postal: '',
    },
  },
  handleInputChange,
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
      <div className="o-grid-12">
        <Textarea
          value={description}
          label={phrase('field_label_details_description', 'Description')}
          name="assignment_description"
          onChange={handleInputChange('description')}
          rows={10}
          required
          textareaProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>
      <div className="o-grid-12">
        <Textarea
          value={benefits}
          label={phrase('field_label_details_benefits', 'benefits')}
          name="assignment_benefits"
          onChange={handleInputChange('benefits')}
          rows={1}
          textareaProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>
      <div className="o-grid-12">
        <Textarea
          value={qualifications}
          label={phrase('field_label_details_qualifications', 'Qualifications')}
          name="assignment_qualifications"
          onChange={handleInputChange('qualifications')}
          rows={4}
          textareaProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>
      <div className="o-grid-12">
        <Textarea
          value={schedule}
          label={phrase('field_label_details_when_and_where', 'When and where?')}
          name="assignment_when_and_where"
          onChange={handleInputChange('schedule')}
          rows={4}
          textareaProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>
      <div className="o-grid-12">
        <Field
          value={totalSpots?.toString() ?? ''}
          label={phrase('field_label_spots', 'Total spots')}
          name="assignment_total_spots"
          type={!isSubmitted ? 'number' : 'text'}
          onChange={handleInputChange('totalSpots')}
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
      </div>
      <div className="o-grid-12">
        <Field
          value={location?.address || ''}
          label={phrase('field_label_assignment_location_address', 'Address')}
          name="assignment_location_address"
          type="text"
          onChange={handleInputChange('location.address')}
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>
      <div className="o-grid-12 o-grid-6@md">
        <Field
          value={location?.postal || ''}
          label={phrase('field_label_assignment_location_postal', 'Postal')}
          name="assignment_location_postal"
          type="number"
          onChange={handleInputChange('location.postal')}
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>
      <div className="o-grid-12 o-grid-6@md">
        <Field
          value={location?.city || ''}
          label={phrase('field_label_assignment_location_city', 'City')}
          name="assignment_location_city"
          type="text"
          onChange={handleInputChange('location.city')}
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>
    </FormSection>
  )
}

export default DetailsFields
