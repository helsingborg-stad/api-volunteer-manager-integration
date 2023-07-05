import React from 'react'

export interface Volunteer {
  id: string
  firstName: string
  lastName: string
  email?: string
  phone?: string
  status?: string
  statusLabel?: string
  assignments?: {
    assignmentId: number
    title: string
    status: string
    statusLabel: string
  }[]
}

export interface Employer {
  name: string
  website: string
  contacts: [Contact, ...Contact[]]
  location?: Location
  about?: string
}

export interface Contact {
  name?: string
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
  Contact = 'contact',
  Internal = 'internal',
}

export type SignUpWithWebsite = {
  type: SignUpTypes.Link
  link: string
  phone?: string
  email?: string
  hasDeadline?: string
  deadline?: string
}

export type SignUpWithContact = {
  type: SignUpTypes.Contact
  phone?: string
  email?: string
  name?: string
  hasDeadline?: string
  deadline?: string
}

export type SignUpIsInternal = {
  type: SignUpTypes.Internal
  phone?: ''
  email?: ''
  name?: ''
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
        name?: string
        phone?: string
        email?: string
        hasDeadline?: 'yes' | 'no' | ''
        deadline?: string
      }
    | (SignUpWithWebsite | SignUpWithContact | SignUpIsInternal)
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
  image?: FileList | null
}

export interface Assignment extends AssignmentInput {
  id: number | null
}

export interface VolunteerServiceContextType {
  registerVolunteer: (input: Volunteer) => Promise<Volunteer>
  registerAssignment: (input: AssignmentInput) => Promise<Assignment>
  getVolunteer: () => Promise<Volunteer>
  applyToAssignment: (assignmentId: number) => Promise<void>
  getAssignment: (assignmentId: number) => Promise<Assignment>
}

const notImplemented = () => {
  throw new Error('not implemented')
}

const VolunteerServiceContext = React.createContext<VolunteerServiceContextType>({
  getVolunteer: notImplemented,
  registerVolunteer: notImplemented,
  registerAssignment: notImplemented,
  applyToAssignment: notImplemented,
  getAssignment: notImplemented,
})

export default VolunteerServiceContext
