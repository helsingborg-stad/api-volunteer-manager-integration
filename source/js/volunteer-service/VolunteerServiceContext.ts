import React from 'react'

export interface VolunteerInput {
  email: string
  phoneNumber?: string
}

export interface Volunteer {
  id: string
  firstName: string
  lastName: string
  email?: string
  phone?: string
  status?: string
}

export interface Employer {
  name: string
  website: string
  contacts: [Contact, ...Contact[]]
  location?: Location
}

export interface Contact {
  name: string
  email?: string
  phone?: string
}

export interface Location {
  address: string
  postal: string
  city: string
}

export enum SignUpTypes {
  Link = 'link',
  Email = 'email',
  Phone = 'phone',
}

export type SignUpWithWebsite = {
  type: SignUpTypes.Link
  link: string
  hasDeadline?: string
  deadline?: string
}

export type SignUpWithEmail = {
  type: SignUpTypes.Email
  email: string
  phone?: string
  hasDeadline?: string
  deadline?: string
}

export type SignUpWithPhone = {
  type: SignUpTypes.Phone
  phone: string
  email?: string
  name?: string
  hasDeadline?: string
  deadline?: string
}

export interface AssignmentInput {
  title: string
  description: string
  employer: Employer
  signUp:
    | {
        type?: SignUpTypes
        link?: string
        phone?: string
        email?: string
        hasDeadline?: string
        deadline?: string
      }
    | (SignUpWithWebsite | SignUpWithEmail | SignUpWithPhone)
  qualifications?: string
  schedule?: string
  benefits?: string
  totalSpots?: number
  location?: Location
  when?: string
  where?: string
  readMoreLink?: string
  publicContact?: {
    name?: string
    phone?: string
    email?: string
  }
}

export interface Assignment extends AssignmentInput {
  id: number
  slug: string
  status: string
}

export interface VolunteerServiceContextType {
  registerVolunteer: (input: VolunteerInput) => Promise<Volunteer>
  registerAssignment: (input: AssignmentInput) => Promise<Assignment>
  getVolunteer: () => Promise<Volunteer>
}

const notImplemented = () => {
  throw new Error('not implemented')
}

const VolunteerServiceContext = React.createContext<VolunteerServiceContextType>({
  getVolunteer: notImplemented,
  registerVolunteer: notImplemented,
  registerAssignment: notImplemented,
})

export default VolunteerServiceContext
