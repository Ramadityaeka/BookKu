# Security Policy

## Supported Versions

| Version | Supported          |
| ------- | ------------------ |
| Latest  | :white_check_mark: |

## Security Best Practices

### Environment Variables
- **Never commit** `.env` files with production credentials
- Use Railway's environment variable injection for production
- Rotate database passwords regularly
- Use strong passwords (minimum 16 characters with mixed case, numbers, and symbols)

### Database Security
- Always use prepared statements (CodeIgniter does this by default)
- Enable SSL/TLS for database connections in production
- Limit database user permissions to only what's needed
- Regular backups of production database

### Application Security
- Keep PHP and CodeIgniter updated to latest versions
- Review and update Composer dependencies regularly
- Enable CSRF protection (enabled by default in CodeIgniter)
- Use parameterized queries for all database operations
- Sanitize all user inputs
- Validate file uploads strictly

### Deployment Security
- Use HTTPS only (Railway provides this automatically)
- Set `CI_ENVIRONMENT=production` in production
- Disable error display in production
- Enable proper logging
- Regular security audits

### File Permissions
- Writable directories should not be web-accessible
- Set proper file permissions (755 for directories, 644 for files)
- Only `public/` directory should be accessible via web

### Health Check Endpoint
The health check endpoint (`/healthz.php`) is designed to:
- Not expose sensitive information
- Log detailed errors server-side only
- Return generic status messages to clients
- Use appropriate HTTP status codes

## Reporting a Vulnerability

If you discover a security vulnerability in BookKu, please follow these steps:

1. **Do NOT** open a public issue
2. Email the maintainer directly at the GitHub profile contact
3. Include:
   - Description of the vulnerability
   - Steps to reproduce
   - Potential impact
   - Suggested fix (if any)

### Response Timeline
- **Initial Response**: Within 48 hours
- **Status Update**: Within 7 days
- **Fix Timeline**: Depends on severity
  - Critical: Within 24-48 hours
  - High: Within 7 days
  - Medium: Within 30 days
  - Low: Next release cycle

### Recognition
Security researchers who responsibly disclose vulnerabilities will be:
- Acknowledged in the CHANGELOG (if desired)
- Listed in this SECURITY.md file (with permission)
- Given credit for the discovery

## Security Checklist for Deployment

Before deploying to production, ensure:

- [ ] All sensitive data uses environment variables
- [ ] `.env` file is in `.gitignore`
- [ ] Database credentials are strong and unique
- [ ] `CI_ENVIRONMENT=production` is set
- [ ] Error display is disabled in production
- [ ] HTTPS is enabled (automatic with Railway)
- [ ] Database backups are configured
- [ ] Monitoring and logging are enabled
- [ ] All dependencies are up to date
- [ ] Security headers are configured
- [ ] CSRF protection is enabled
- [ ] File upload restrictions are in place

## Known Security Considerations

### Current Implementation
1. **Database Credentials**: Stored in environment variables (✅ Secure)
2. **Error Handling**: Generic messages for production (✅ Secure)
3. **Health Check**: No sensitive data exposed (✅ Secure)
4. **Charset**: UTF-8 MB4 to prevent charset-based attacks (✅ Secure)
5. **CSRF**: CodeIgniter's built-in protection (✅ Secure)

### Recommendations
1. **Rate Limiting**: Consider adding rate limiting for API endpoints
2. **WAF**: Consider using a Web Application Firewall
3. **Database SSL**: Enable SSL for database connections in production
4. **Session Security**: Use secure session configuration
5. **Content Security Policy**: Add CSP headers

## Security Updates

Check for security updates regularly:
- PHP: https://www.php.net/ChangeLog-8.php
- CodeIgniter: https://github.com/codeigniter4/CodeIgniter4/security/advisories
- Dependencies: Run `composer audit` regularly

## Additional Resources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [CodeIgniter Security Guidelines](https://codeigniter.com/user_guide/concepts/security.html)
- [Railway Security Best Practices](https://docs.railway.app/develop/variables#security)

## Contact

For security concerns, please contact:
- GitHub: [@Ramadityaeka](https://github.com/Ramadityaeka)
- Open an issue (for non-security bugs)

---

**Last Updated**: November 2025
