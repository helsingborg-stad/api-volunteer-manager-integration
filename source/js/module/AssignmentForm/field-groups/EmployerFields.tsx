import { useContext } from 'react'
import FormSection from '../../../components/form/FormSection'
import PhraseContext from '../../../phrase/PhraseContextInterface'
import { Field, Textarea } from '@helsingborg-stad/municipio-react-ui'
import { parseValue } from '../../../util/event'
import { maybeNormalizeUrl } from '../../../util/url'
import Grid from '../../../components/grid/Grid'
import { FieldGroupProps } from './FieldGroupProps'

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
      <Grid col={12}>
        <Textarea
          value={employer?.about || ''}
          label={phrase('field_label_employer_about', 'About the employer')}
          name="assignment_employer_about"
          onChange={parseValue(handleChange('employer.about'))}
          textareaProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />
      </Grid>

      <Grid col={12}>
        <Field
          value={employer?.website || ''}
          label={phrase('field_label_employer_website', 'Website')}
          name="assignment_employer_webite"
          type="url"
          onChange={parseValue(handleChange('employer.website'))}
          onBlur={() => maybeNormalizeUrl(employer?.website, handleChange('employer.website'))}
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
          placeholder={phrase('field_placeholder_employer_website', 'https://')}
        />
      </Grid>
    </FormSection>
  )
}

export default EmployerFields
