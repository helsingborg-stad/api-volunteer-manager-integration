import FormSection from '../form/FormSection'
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
        <Field
          value={readMoreLink}
          label={phrase('field_label_read_more_link', 'Read more link')}
          name="assignment_read_more_link"
          type="url"
          onChange={handleInputChange('readMoreLink')}
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>
      <div className="o-grid-12">
        <Textarea
          value={when}
          label={phrase('field_label_details_when', 'When')}
          name="assignment_when"
          onChange={handleInputChange('when')}
          rows={4}
          textareaProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>
      <div className="o-grid-12">
        <Textarea
          value={where}
          label={phrase('field_label_details_were', 'Where')}
          name="assignment_where"
          onChange={handleInputChange('where')}
          rows={3}
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
    </FormSection>
  )
}

export default DetailsFields
