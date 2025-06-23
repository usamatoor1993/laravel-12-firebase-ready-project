# 🚀 Laravel 12 Firebase Ready Starter

A clean and modern Laravel 12 starter project fully integrated with **Firebase Firestore** — with easy setup, gRPC Windows fix, and example code for reading/writing Firestore documents.

✅ Perfect for developers who want to skip Firebase headaches and start building fast.

---

## ⚙️ Features

- 🔥 Firestore integration (via `google/cloud-firestore`)
- 🛠️ gRPC Windows-friendly setup (`cacert.pem`)
- 📂 Credential-based Firebase setup
- 📦 Laravel 12-ready boilerplate
- ✅ Example: Read/write Firestore documents
- 🔐 .env support for easy config

---

## 🚀 Getting Started

### 1. Clone the repo

```bash
git clone https://github.com/usamatoor1993/laravel-12-firebase-ready-project.git
cd laravel-12-firebase-ready-project
```

### 2. Install dependencies

```bash
composer install
cp .env.example .env
php artisan key:generate
```

### 3. Configure your database

Edit `.env` for DB config:

```env
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
```

Then run:

```bash
php artisan migrate
```

---

## 🔥 Firebase Setup

### 1. Get Firebase credentials

- Go to [Firebase Console](https://console.firebase.google.com/)
- Open your project → **Project Settings → Service Accounts**
- Click **"Generate new private key"**
- Rename it to: `credentials.json`

Place it in the project root.

### 2. Download `cacert.pem` for gRPC (Windows fix)

- Download from: https://curl.se/ca/cacert.pem
- Save it in your root as `cacert.pem`

---

## 🔐 .env Configuration

```env
FIREBASE_CREDENTIALS=credentials.json
FIREBASE_CERT_PATH=cacert.pem

SESSION_DRIVER=file
```

---

## 📄 Firestore Example Usage

Here’s a simple example of reading user documents from Firestore:

```php
use Google\Cloud\Firestore\FirestoreClient;

putenv('GOOGLE_APPLICATION_CREDENTIALS=' . base_path(env('FIREBASE_CREDENTIALS')));
putenv('GRPC_DEFAULT_SSL_ROOTS_FILE_PATH=' . base_path(env('FIREBASE_CERT_PATH')));

$db = new FirestoreClient(['projectId' => 'your-project-id']);
$users = $db->collection('Users')->documents();

foreach ($users as $user) {
    if ($user->exists()) {
        dump($user->data());
    }
}
```

You can also see the full migration logic inside `FirestoreMigrationController`.

---

## ❗ Common Issues

### ❌ `Could not get default pem root certs`

✅ Fix:
```env
FIREBASE_CERT_PATH=cacert.pem
```
And ensure `cacert.pem` is present in your root.

---

### ❌ `Table 'carchive.sessions' doesn't exist`

✅ Fix:
```bash
php artisan session:table
php artisan migrate
```

Or set in `.env`:
```env
SESSION_DRIVER=file
```

---

## 📂 Recommended Structure

```
project-root/
├── app/
│   └── Http/
│       └── Controllers/
│           └── FirestoreMigrationController.php
├── credentials.json
├── cacert.pem
├── .env
```

---

## 🙌 Contributing

PRs welcome! If you find bugs or want to improve this starter, feel free to open an issue or send a pull request.

---

## 👨‍💻 Author

Developed by [Usama Toor](https://github.com/usamatoor1993) — backend developer with love for Laravel and clean architecture.

---

## 📄 License

MIT — free to use for personal or commercial projects.