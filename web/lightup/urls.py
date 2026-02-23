from django.urls import path

from lightup import pyCode, views

app_name = "lightup"

urlpatterns = [
    path("", views.home, name="home"),
    path("chinesebible/", pyCode.chineseBible, name="chinesebible"),
    path("hello/", pyCode.hello, name="hello"),
    path("engbible/", pyCode.engBible, name="engbible"),
    path("happiness/", pyCode.happiness, name="happiness"),
    path("members/", views.member_list, name="member_list"),
    path("members/<int:member_id>", views.member_detail, name="member_detail"),
    path("income/", views.income_list, name="income_list"),
    path("outcome/", views.outcome_list, name="outcome_list"),
    #path("uploadcsv/", views.upload_csv, name="uploadcsv"),
]
