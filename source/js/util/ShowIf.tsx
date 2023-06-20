export const ShowIf = ({
  condition,
  children,
}: {
  condition: boolean
  children: JSX.Element | JSX.Element[]
}): JSX.Element => <>{condition ? children : null}</>

export default ShowIf
