
import os
import django
from django.urls import reverse, get_resolver

os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'myproject.settings')
django.setup()

try:
    print(f"Reverse 'lightup:member_list': {reverse('lightup:member_list')}")
    # Assuming ID 1 exists for testing pattern match
    print(f"Reverse 'lightup:member_detail': {reverse('lightup:member_detail', args=[1])}")
except Exception as e:
    print(f"Error reversing URLs: {e}")

print("\nListing all registered URLs:")
resolver = get_resolver()
for namespace, (url_patterns, app_name) in resolver.namespace_dict.items():
    print(f"Namespace: {namespace}, App: {app_name}")

def print_patterns(patterns, prefix=''):
    for pattern in patterns:
        if hasattr(pattern, 'url_patterns'):
            print_patterns(pattern.url_patterns, prefix + pattern.pattern.regex.pattern)
        else:
            name = getattr(pattern, 'name', None)
            print(f"{prefix}{pattern.pattern.regex.pattern} -> Name: {name}")

print_patterns(resolver.url_patterns)
