# Backend – API PHP

## Objectif
Ce dossier contient les futures API PHP utilisées par le frontend Vue.js.

## Règles
- 1 fichier PHP = 1 endpoint
- Les API renvoient UNIQUEMENT du JSON
- Toujours inclure :
    - database.php
    - headers CORS

## Exemple minimal d’API
```php
<?php
require_once "../config/database.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

echo json_encode(["status" => "ok"]);


---

# 🎨 FRONTEND – BASE VUE 3

## `src/main.js`
```js
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import "./assets/main.css";

createApp(App).use(router).mount("#app");
