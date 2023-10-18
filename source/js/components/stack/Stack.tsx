import React, { PropsWithChildren } from 'react'
import ShowIf from '../../util/ShowIf'

export interface Props extends PropsWithChildren {
  className?: string
  spacing?: number
  base?: number
  unit?: string
}

export const Stack = ({
  spacing = 1,
  base = 8,
  unit = 'px',
  className = undefined,
  children,
  ...props
}: Props) => {
  const computedMargin = `${spacing * base}${unit}`

  return (
    <div
      className={[...['o-stack'], className ?? ''].filter((s) => s && s.length > 0).join(' ')}
      {...props}>
      {React.Children.map(children, (child, index) => (
        <ShowIf condition={child !== null}>
          <div style={{ marginTop: index === 0 ? '0' : computedMargin }} key={index}>
            {child}
          </div>
        </ShowIf>
      ))}
    </div>
  )
}

export default Stack
