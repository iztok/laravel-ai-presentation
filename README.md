## How to Install This Presentation

To install and run this presentation, follow these steps:

1. **Clone the Repository**
```bash
git clone https://github.com/iztok/laravel-ai-presentation.git
```

2. **Navigate to the Project Directory**
```bash
cd laravel-ai-presentation
```

3. **Install Dependencies**
```bash
composer install
npm install
```

3. **Set .env**
```bash
cp .env.example .env
```

3. **Set API keys for external services**
```
OPENAI_API_KEY=
ANTHROPIC_API_KEY=
OPENWEATHER_API_KEY=
```

4. **Build front-end**
```bash
npm run build
```

5. **Run server**
```bash
php artisan serve
```

6. **Visit website on http://127.0.0.1:8000**
