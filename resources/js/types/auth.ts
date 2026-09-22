export type User = {
    id: string
    name: string
    email: string
    avatar: string | null
    dexterity: 'left' | 'right' | null
    handicap: string | null
    experience: 'beginner' | 'intermediate' | 'advanced' | 'pro' | null
    email_verified_at: string | null
    created_at: string
    updated_at: string
    [key: string]: unknown
}

export type Auth = {
    user: User | null
}
