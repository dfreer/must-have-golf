# Copilot Instructions

## Local Dev
- When in local env, do not add new migrations to edit columns- you should edit existing migrations.
- If db schema changes, run php artisan migrate:fresh to wipe and start over

## Data Model Rules
- All models should extend the BaseModel
- All primary keys must use ULIDs (`$table->ulid('id')->primary()` in migrations).
- Migrations should not use enums. They should be strings and then managed by php enums in the app
- Migrations should use foreignUlids for fields that reference other models
- Use php8 attributes for models, example:
  #[Fillable(['name', 'email', 'password'])]
  #[Hidden(['password', 'remember_token'])]
- Do not include relationships within fillable. All relationships should be added with model methods
