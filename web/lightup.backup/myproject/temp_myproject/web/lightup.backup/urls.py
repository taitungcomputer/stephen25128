from django.urls import path
from lightup import views

urlpatterns = [
    path("", views.home, name="home"),
]
