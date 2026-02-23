# Activity Tracking System

Laravel application for tracking daily activities of an applications support team.

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- SQLite (included with PHP)

### Setup Steps

1. Clone the repository
   ```bash
   git clone https://github.com/yourusername/activity-tracker.git
   cd activity-tracker
   ```

2. Install dependencies
   ```bash
   composer install
   ```

3. Configure environment
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Setup database
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

5. Start the server
   ```bash
   php artisan serve
   ```

6. Access the application
   - Open browser: `http://localhost:8000`
   - Register a new user account
   - Start using the application

## Features

- User authentication system
- Create and manage daily activities
- Update activity status (pending/done) with remarks
- Track personnel bio details and update timestamps
- Daily view for handover management
- Reporting with custom date range queries
- Export reports to CSV format

## Requirements Implementation

1. Activity input functionality
2. Status updates with remarks
3. Bio details and timestamp capture
4. Daily activities view with update history
5. Reporting with date range queries
6. User authentication system

## Technology Stack

- Laravel 10
- SQLite Database
- Blade Templates
- Tailwind CSS

## Deployment

For deployment instructions, see `STEP_BY_STEP_DEPLOYMENT.md`
