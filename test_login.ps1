$session = New-Object Microsoft.PowerShell.Commands.WebRequestSession

# Get login page to extract CSRF
$response = Invoke-WebRequest -Uri "http://localhost/laundryfresh/public/login" -UseBasicParsing
$session.Cookies.AddCookieHeader($response.BaseResponse)

# Extract CSRF token
$token = $response.Content | Select-String 'value="([a-zA-Z0-9]+)"' -Raw | % { $_.Split('"')[1] } | Select-Object -First 1

Write-Host "Logging in with token: $token"

# Submit login
$loginResponse = Invoke-WebRequest -Uri "http://localhost/laundryfresh/public/login" `
    -Method POST `
    -Body @{
        'email' = 'test@example.com'
        'password' = 'password'
        '_token' = $token
    } `
    -WebSession $session `
    -UseBasicParsing

Write-Host "Login StatusCode: $($loginResponse.StatusCode)"

# Now access admin dashboard
$adminResponse = Invoke-WebRequest -Uri "http://localhost/laundryfresh/public/admin" `
    -WebSession $session `
    -UseBasicParsing

Write-Host "Admin page size: $($adminResponse.Content.Length) bytes"

# Check if admin page has expected content
if ($adminResponse.Content -like "*Admin Dashboard*") {
    Write-Host "PASS: Admin Dashboard content found!"
} else {
    Write-Host "FAIL: Admin Dashboard NOT found"
}

if ($adminResponse.Content -like "*Kelola Layanan*") {
    Write-Host "PASS: Services section found!"
} else {
    Write-Host "FAIL: Services section NOT found"
}

if ($adminResponse.Content -like "*Laporan Keuangan*") {
    Write-Host "PASS: Finance section found!"
} else {
    Write-Host "FAIL: Finance section NOT found"
}
