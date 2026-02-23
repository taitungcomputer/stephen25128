
import os
import django
from django.urls import reverse
from django.test import RequestFactory
from lightup import views

os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'myproject.settings')
django.setup()

try:
    url = reverse('lightup:outcome_list')
    print(f"Outcome List URL: {url}")
    
    # Simple view smoke test
    factory = RequestFactory()
    request = factory.get(url)
    response = views.outcome_list(request)
    print(f"View Response Status: {response.status_code}")
except Exception as e:
    print(f"Verification Error: {e}")
