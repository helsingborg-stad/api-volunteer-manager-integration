import { Typography } from '@helsingborg-stad/municipio-react-ui'
import { PropsWithChildren } from 'react'

interface Props extends PropsWithChildren {
  sectionTitle: string
  sectionDescription?: string
  isSubSection?: boolean
}

export const FormSection = ({
  sectionTitle,
  sectionDescription,
  children,
  isSubSection = false,
}: Props) => (
  <div className="o-grid form-section">
    <div className="o-grid o-grid--form">
      <div className="o-grid-12 u-margin__bottom--2">
        <Typography element={isSubSection ? 'h3' : 'h2'}>{sectionTitle}</Typography>
        {(sectionDescription?.length ?? 0) > 0 ? (
          <div className="u-margin__top--1">
            <Typography element="p">{sectionDescription}</Typography>
          </div>
        ) : null}
      </div>
      {children ?? null}
    </div>
  </div>
)

export default FormSection
