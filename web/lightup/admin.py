from django.contrib import admin
from lightup.models import (
    Family,
    Member,
    Donate,
    Income_item,
    Outcome_item,
    Income,
    Outcome,
    Course,
    Enroll,
)

# ------------------------------
# Family Admin
# ------------------------------
@admin.register(Family)
class FamilyAdmin(admin.ModelAdmin):
    list_display = ("name", "created_at", "updated_at")
    search_fields = ("name",)
    list_filter = ("created_at",)


# ------------------------------
# Member Admin
# ------------------------------
@admin.register(Member)
class MemberAdmin(admin.ModelAdmin):
    # 列出主要欄位，太多欄位會太亂
    list_display = (
        "name",
        "personal_id",
        "gender",
        "mobile",
        "email",
        "marriage",
        "status",
        "family",
        "agreement_icon",
    )

    # 搜尋欄位
    search_fields = ("name", "personal_id", "mobile", "email")

    # 過濾器
    list_filter = ("gender", "marriage", "status", "tribe", "job", "lecture", "agreement")

    # boolean 欄位用 icon
    def agreement_icon(self, obj):
        return obj.agreement
    agreement_icon.boolean = True
    agreement_icon.short_description = "是否同意條款"


# ------------------------------
# Donate Admin
# ------------------------------
@admin.register(Donate)
class DonateAdmin(admin.ModelAdmin):
    list_display = ("name", "created_at", "updated_at")
    search_fields = ("name",)


# ------------------------------
# Income_item Admin
# ------------------------------
@admin.register(Income_item)
class IncomeItemAdmin(admin.ModelAdmin):
    list_display = ("name", "created_at", "updated_at")
    search_fields = ("name",)


# ------------------------------
# Outcome_item Admin
# ------------------------------
@admin.register(Outcome_item)
class OutcomeItemAdmin(admin.ModelAdmin):
    list_display = ("name", "created_at", "updated_at")
    search_fields = ("name",)


# ------------------------------
# Income Admin
# ------------------------------
@admin.register(Income)
class IncomeAdmin(admin.ModelAdmin):
    list_display = (
        "name",
        "record_date",
        "member",
        "donate",
        "income_item",
        "account",
    )
    search_fields = ("name", "member__name", "donate__name")
    list_filter = ("record_date", "income_item")


# ------------------------------
# Outcome Admin
# ------------------------------
@admin.register(Outcome)
class OutcomeAdmin(admin.ModelAdmin):
    list_display = ("name", "record_date", "outcome_item", "account")
    search_fields = ("name",)
    list_filter = ("record_date", "outcome_item")


# ------------------------------
# Course Admin
# ------------------------------
@admin.register(Course)
class CourseAdmin(admin.ModelAdmin):
    list_display = ("name", "start_date", "end_date", "account", "consume")
    search_fields = ("name",)
    list_filter = ("start_date", "end_date")


# ------------------------------
# Enroll Admin
# ------------------------------
@admin.register(Enroll)
class EnrollAdmin(admin.ModelAdmin):
    list_display = ("member", "course")
    search_fields = ("member__name", "course__name")
    list_filter = ("course",)
