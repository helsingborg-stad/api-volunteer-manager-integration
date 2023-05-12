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

export interface AssignmentInput {
  title: string
}

export interface Assignment {
  title: string
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
