import { Typography } from '@helsingborg-stad/municipio-react-ui'
import { PropsWithChildren } from 'react'

interface Props extends PropsWithChildren {
  sectionTitle: string
  sectionDescription?: string
  isSubSection?: boolean
}

export const ImagePicker = ({
  sectionTitle,
  sectionDescription,
  children,
  isSubSection = false,
}: Props) => (
  <div className="o-grid">
    <div className="o-grid o-grid--form">
      <div className="o-grid-12">
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

export default ImagePicker
