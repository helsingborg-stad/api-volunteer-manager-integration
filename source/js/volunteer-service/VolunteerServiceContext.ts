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

export interface Organisation {
  name: string
  website: string
  contacts: [Contact, ...Contact[]]
  location?: Location
}

export interface Contact {
  name: string
  email: string
  phone?: string
}

export interface Location {
  address: string
  postal: string
  city: string
}

export enum SignUpTypes {
  Website = 'website',
  Email = 'email',
  Phone = 'phone',
}

export type SignUpWithWebsite = {
  type: SignUpTypes.Website
  website: string
}

export type SignUpWithEmail = {
  type: SignUpTypes.Email
  email: string
}

export type SignUpWithPhone = {
  type: SignUpTypes.Phone
  phone: string
}

export interface AssignmentInput {
  title: string
  description: string
  organisation: Organisation
  signUp: {
    type: SignUpTypes
    website?: string
    phone?: string
    email?: string
  } & (SignUpWithWebsite | SignUpWithEmail | SignUpWithPhone)
  qualifications?: string
  schedule?: string
  benefits?: string
  totalSpots?: number
  location?: Location
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
