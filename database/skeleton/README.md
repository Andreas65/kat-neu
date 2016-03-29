# DATABASE MIGRATION AND DEPLOYMENT

This folder contains migration files for the database "skeleton".

## Developers

If you're working on a database change create a file containing the changes named like the ticket id: `aiduws-123.sql`.
The file must contain a description and your name in the following format (first two lines):

```
-- //@description XXXX-xx: Description of change
-- //@appliedBy j.doe
```

Create a pull request and tell the reviewer, that the database schema will change.

## Reviewer

After you tested and reviewed the database changes, merge the pull request
and rename the files according to the standard (inside the target branch):

- `00001.sql`
- `00002.sql`
- `00003.sql`
- `aiduws-123.sql` -> `00004.sql`

Test that the migration still is working before commiting the renamed file.
