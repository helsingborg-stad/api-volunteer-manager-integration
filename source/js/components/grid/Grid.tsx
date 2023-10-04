import { PropsWithChildren } from 'react'

type ColumnSize = 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9 | 10 | 11 | 12 | 'auto'

interface GridProps extends PropsWithChildren {
  container?: boolean
  className?: string
  col?: ColumnSize
  xs?: ColumnSize
  md?: ColumnSize
  lg?: ColumnSize
  xl?: ColumnSize
}

interface GridContainerProps extends GridProps {
  container: true
  col?: undefined
  xs?: undefined
  md?: undefined
  lg?: undefined
  xl?: undefined
}

interface GridColumnProps extends GridProps {
  container?: false
  col?: ColumnSize
  xs?: ColumnSize
  md?: ColumnSize
  lg?: ColumnSize
  xl?: ColumnSize
}

export type Props = GridContainerProps | GridColumnProps

export const Grid = ({ children, className, container, col, xs, md, lg, xl, ...props }: Props) => (
  <div
    className={[
      ...(container
        ? ['o-grid']
        : [
            col ? `o-grid-${col}` : 'o-grid-12',
            xs ? `o-grid-${xs}@xs` : '',
            md ? `o-grid-${md}@md` : '',
            lg ? `o-grid-${lg}@lg` : '',
            xl ? `o-grid-${xl}@xl` : '',
          ]),
      className ?? '',
    ]
      .filter((s) => s && s.length > 0)
      .join(' ')}
    {...props}>
    {children ?? null}
  </div>
)

export default Grid
