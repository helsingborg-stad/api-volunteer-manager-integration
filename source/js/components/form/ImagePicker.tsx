import { useCallback, useRef } from 'react'
import {
  Button,
  Collection,
  CollectionContent,
  CollectionIcon,
  CollectionItem,
  CollectionSecondary,
  Icon,
  Typography,
} from '@helsingborg-stad/municipio-react-ui'
import './image-picker.scss'

export interface ImagePickerProps {
  name: string
  value?: FileList | null
  label?: string
  onChange?: (value: FileList | null) => void
  error?: boolean
  valid?: boolean
  helperText?: string | JSX.Element
  readOnly?: boolean
  required?: boolean
  width?: number
  height?: number
}

const ImagePicker = ({
  value,
  onChange,
  label,
  name,
  error,
  valid,
  helperText,
  required,
  readOnly: readOnly,
  width = 1920,
  height = 1080,
  ...props
}: ImagePickerProps): JSX.Element => {
  const inputRef = useRef<HTMLInputElement | null>(null)
  const resetInput = useCallback(() => {
    if (inputRef.current !== null) {
      inputRef.current.value = ''
    }
  }, [])
  const classNames = [
    'c-field',
    'c-field--image-picker',
    ...(value ? ['has-value'] : []),
    ...(error ? ['is-invalid'] : []),
    ...(valid ? ['is-valid'] : []),
    ...(readOnly ? ['c-field--readonly'] : []),
  ].join(' ')
  const aspectRatioPaddingTop = (height / width) * 100
  return (
    <div {...props} className={classNames}>
      {label && (
        <label className="c-field__label" htmlFor={name}>
          {label}{' '}
          {required ? (
            <span className="u-color__text--danger" aria-hidden="true">
              *
            </span>
          ) : null}
        </label>
      )}

      <div className="c-field__inner c-field__inner--dropzone">
        <input
          id={name}
          aria-label={label}
          aria-required={required ? 'true' : 'false'}
          type="file"
          {...(readOnly ? { readOnly } : {})}
          {...(required ? { required } : {})}
          onChange={(e) => e.target.files && onChange && onChange(e.target.files)}
          name={name}
        />

        <div
          className="c-field__dropzone"
          style={{
            paddingTop: `${aspectRatioPaddingTop}%`,
          }}>
          <div className="c-field__dropzone-inner">
            {value?.length && value.length > 0 ? (
              <img
                className="c-field__dropzone-image"
                src={URL.createObjectURL(value[0])}
                alt={value[0].name}
              />
            ) : (
              <label className="c-field__dropzone-label">
                <div className="u-margin__bottom--1">
                  <Icon name="upload_file" size="lg" />
                </div>
                <div>
                  <Typography>
                    Dra och släpp eller <a>välj en bild</a> att ladda upp
                  </Typography>
                </div>
              </label>
            )}
          </div>
        </div>
      </div>

      {value?.length && value.length > 0 ? (
        <div className="c-field__inner u-margin__top--2">
          <Collection className="c-collection--compact u-width--100">
            <CollectionItem>
              <CollectionIcon>
                <Icon name="upload_file" />
              </CollectionIcon>
              <CollectionContent className="u-padding__left--0 u-display--flex u-align-items--center">
                <Typography className="u-word-break-all" variant="caption" as="p">
                  {value[0].name}
                </Typography>
              </CollectionContent>
              <CollectionSecondary className="u-display--flex u-align-items--center u-padding__x--0">
                <Button
                  color="primary"
                  size="sm"
                  variant="basic"
                  onClick={() =>
                    [() => resetInput(), () => (onChange ? onChange(null) : null)].forEach((fn) =>
                      fn(),
                    )
                  }>
                  <Icon name="close" />
                </Button>
              </CollectionSecondary>
            </CollectionItem>
          </Collection>
        </div>
      ) : null}

      <div className="c-field_focus-styler u-level-top"></div>
      {helperText ? <div className="c-field__helper">{helperText}</div> : null}
    </div>
  )
}
export default ImagePicker

export { ImagePicker }
