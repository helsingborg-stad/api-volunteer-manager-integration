import { useMemo } from 'react'
import VolunteerServiceContext from '../VolunteerServiceContext'
import { createRestContext } from './create-rest-context'

type VolunteerServiceProviderProps = {
  uri: string
  children: JSX.Element[] | JSX.Element
}

const VolunteerServiceProvider = ({
  uri,
  children,
}: VolunteerServiceProviderProps): JSX.Element => {
  const provider = useMemo(() => createRestContext(uri), [uri])

  return (
    <VolunteerServiceContext.Provider value={provider}>{children}</VolunteerServiceContext.Provider>
  )
}

export { VolunteerServiceProvider }
