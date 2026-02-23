from django.urls import path
from applications import views

urlpatterns = [
    path("hello/", views.hello, name="hello"),
    path("now/", views.dd, name="now"),
    path("search/", views.search, name="search"),
    path("tt/<str:name>/", views.tt, name="tt"),
    path("detail/<int:year>/<int:month>/<slug:slug>/",
         views.detail, 
         name="detail",
        ),
    path("bmi/",views.bmi, name="bmi"),
    path("biblequiz/",views.quiz_view, name="biblequiz"),
    path("biblereview/",views.biblereview, name="biblereview"),
    path("vocabulary/",views.vocabulary, name="vocabulary"),

]