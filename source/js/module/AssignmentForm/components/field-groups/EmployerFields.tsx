import FormSection from '../../../../components/form/FormSection'
import PhraseContext from '../../../../phrase/PhraseContextInterface'
import { useContext } from 'react'
import { Field, Textarea } from '@helsingborg-stad/municipio-react-ui'

import { FieldGroupProps } from './FieldGroupProps'

import { parseValue } from '../../../../util/event'

export const EmployerFields = ({
  formState: { employer },
  handleChange,
  isLoading,
  isSubmitted,
}: FieldGroupProps) => {
  const { phrase } = useContext(PhraseContext)

  return (
    <FormSection
      sectionTitle={phrase('form_section_label_employer', 'Employer information')}
      sectionDescription={
        !isSubmitted
          ? phrase(
              'form_section_description_employer',
              'Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.',
            )
          : undefined
      }
      isSubSection>
      <div className="o-grid-12 o-grid-12@md">
        <Textarea
          value={employer?.about || ''}
          label={phrase('field_label_employer_about', 'About the employer')}
          name="assignment_employer_about"
          onChange={parseValue(handleChange('employer.about'))}
          textareaProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>

      <div className="o-grid-12">
        <Field
          value={employer?.website || ''}
          label={phrase('field_label_employer_website', 'Website')}
          name="assignment_employer_webite"
          type="url"
          onChange={parseValue(handleChange('employer.website'))}
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </div>
    </FormSection>
  )
}

export default EmployerFields
