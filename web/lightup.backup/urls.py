from django.urls import path

from lightup import pyCode, views

urlpatterns = [
    path("", views.home, name="home"),
    path("chinesebible/", pyCode.chineseBible, name="chinesebible"),
    path("hello/", pyCode.hello, name="hello"),
    path("engbible/", pyCode.engBible, name="engbible"),
    path("happiness/", pyCode.happiness, name="happiness"),
]
