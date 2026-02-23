from django.urls import path

from myapp import views

urlpatterns = [
    path("lotto/", views.lotto, name="lotto"),
    path("showout/", views.luckyNumber, name="luckynumber"),
    path("countsquare/", views.countsqare, name="countsquare"),
    path("countbmi/", views.countbmi, name="countbmi"),
    path("practice/<str:id>",views.practice01, name="practice01"),
    path("guess/",views.guess,name="guess"),
]
