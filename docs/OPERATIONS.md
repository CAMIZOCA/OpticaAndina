# Operación: Deploy y Backups

## Deploy de producción

Ejecuta estos comandos en cada despliegue:

```bash
php artisan optimize:clear
php artisan migrate --force
php artisan storage:link
npm run build
```

## Checklist de deploy

1. Confirmar que `.env` de producción tenga `APP_URL` correcto.
2. Confirmar que `PUBLIC_STORAGE_URL=/storage` salvo que uses un CDN o subdominio de archivos.
3. Confirmar que `public/storage` apunte a `storage/app/public`.
4. Ejecutar migraciones antes de abrir tráfico.
5. Validar:
   - `/`
   - `/sitemap.xml`
   - `/admin`
   - una página de producto
   - una página de servicio

## URLs de archivos en producción

Para evitar errores de CORS en Filament y en las vistas públicas:

```env
APP_URL=https://opticaandina.com.ec
PUBLIC_STORAGE_URL=/storage
```

Notas:

- `APP_URL` debe coincidir con el dominio canónico real del sitio.
- `PUBLIC_STORAGE_URL=/storage` hace que las previews del disco `public` se resuelvan en el mismo dominio actual.
- Si un archivo sigue devolviendo `404`, el problema ya no es CORS sino que falta el symlink `public/storage`, falta el archivo físico o el virtual host apunta a una carpeta incorrecta.

## Backup de base de datos

### MySQL / MariaDB

```bash
mysqldump -u TU_USUARIO -p TU_BASE_DE_DATOS > storage/app/backups/db-$(date +%F).sql
```

En Windows / Laragon puedes usar una variante como:

```powershell
mysqldump -u root -p opticaandina > storage\app\backups\db-%DATE:~10,4%-%DATE:~4,2%-%DATE:~7,2%.sql
```

## Backup de imágenes y archivos públicos

Respaldar al menos:

- `storage/app/public`
- `.env`

Ejemplo Linux:

```bash
tar -czf storage/app/backups/storage-public-$(date +%F).tar.gz storage/app/public .env
```

Ejemplo Windows PowerShell:

```powershell
Compress-Archive -Path storage\\app\\public,.env -DestinationPath storage\\app\\backups\\storage-public.zip -Force
```

## Recomendación mínima

- Base de datos: backup diario
- Imágenes / uploads: backup diario
- Retención: 14 a 30 días
- Guardar copia fuera del servidor
