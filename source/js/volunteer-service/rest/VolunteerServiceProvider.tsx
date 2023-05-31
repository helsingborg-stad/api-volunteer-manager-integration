import { useMemo } from 'react'
import VolunteerServiceContext from '../VolunteerServiceContext'
import { createRestContext } from './create-rest-context'

type VolunteerServiceProviderProps = {
  uri: string
  appSecret?: string
  children: JSX.Element[] | JSX.Element
}

const VolunteerServiceProvider = ({
  uri,
  appSecret,
  children,
}: VolunteerServiceProviderProps): JSX.Element => {
  const provider = useMemo(() => createRestContext(uri, appSecret ?? ''), [uri, appSecret])

  return (
    <VolunteerServiceContext.Provider value={provider}>{children}</VolunteerServiceContext.Provider>
  )
}

export { VolunteerServiceProvider }
