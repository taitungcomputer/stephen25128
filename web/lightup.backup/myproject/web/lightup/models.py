from django.core.validators import MinValueValidator
from django.db import models

# ===========================
# Choices（全部中文）
# ===========================

# 性別
GENDER_CHOICES = [
    ("男", "男"),
    ("女", "女"),
]

# 婚姻狀況
MARRIAGE_CHOICES = [
    ("未婚", "未婚"),
    ("已婚", "已婚"),
    ("離婚", "離婚"),
    ("喪偶", "喪偶"),
]

# 會友狀態
STATUS_CHOICES = [
    ("慕道友", "慕道友"),
    ("受洗", "受洗"),
    ("轉入", "轉入"),
    ("轉出", "轉出"),
    ("離堂", "離堂"),
]

# 部落（族別）
TRIBE_CHOICES = [
    ("阿美族", "阿美族"),
    ("泰雅族", "泰雅族"),
    ("排灣族", "排灣族"),
    ("布農族", "布農族"),
    ("卑南族", "卑南族"),
    ("魯凱族", "魯凱族"),
    ("鄒族", "鄒族"),
    ("賽夏族", "賽夏族"),
    ("達悟族", "達悟族"),
    ("邵族", "邵族"),
    ("噶瑪蘭族", "噶瑪蘭族"),
    ("太魯閣族", "太魯閣族"),
    ("撒奇萊雅族", "撒奇萊雅族"),
    ("賽德克族", "賽德克族"),
    ("拉阿魯哇族", "拉阿魯哇族"),
    ("卡那卡那富族", "卡那卡那富族"),
]

# 職業
JOB_CHOICES = [
    ("學生", "學生"),
    ("軍人", "軍人"),
    ("公務員", "公務員"),
    ("教師", "教師"),
    ("農", "農"),
    ("漁", "漁"),
    ("公務", "公務"),
    ("服務業", "服務業"),
    ("技工", "技工"),
    ("自由業", "自由業"),
    ("家管", "家管"),
    ("退休", "退休"),
    ("其他", "其他"),
]

# 學歷階段
LECTURE_CHOICES = [
    ("學前", "學前"),
    ("小學", "小學"),
    ("國中", "國中"),
    ("高中", "高中"),
    ("大專", "大專"),
    ("大學", "大學"),
    ("碩士", "碩士"),
    ("博士", "博士"),
    ("其他", "其他"),
]


# ===========================
# Models
# ===========================


class Donate(models.Model):
    created_at = models.DateTimeField(auto_now_add=True, verbose_name="建立時間")
    updated_at = models.DateTimeField(auto_now=True, verbose_name="更新時間")
    name = models.CharField(max_length=30, verbose_name="奉獻者抬頭")

    def __str__(self):
        return self.name

    class Meta:
        verbose_name = "奉獻者"
        verbose_name_plural = "奉獻者管理"


class Family(models.Model):
    created_at = models.DateTimeField(auto_now_add=True, verbose_name="建立時間")
    updated_at = models.DateTimeField(auto_now=True, verbose_name="更新時間")

    name = models.CharField(max_length=30, verbose_name="家族名稱")
    introduce = models.TextField(blank=True, verbose_name="家族簡介")
    backup = models.TextField(blank=True, verbose_name="備註")

    def __str__(self):
        return self.name

    class Meta:
        verbose_name = "家族"
        verbose_name_plural = "家族管理"


class Member(models.Model):
    created_at = models.DateTimeField(auto_now_add=True, verbose_name="建立時間")
    updated_at = models.DateTimeField(auto_now=True, verbose_name="更新時間")

    personal_id = models.CharField(max_length=15, unique=True, verbose_name="身分證")
    name = models.CharField(max_length=30, verbose_name="姓名")
    gender = models.CharField(
        max_length=10, choices=GENDER_CHOICES, verbose_name="性別"
    )

    born = models.DateField(verbose_name="出生日期")
    address = models.CharField(max_length=60, verbose_name="地址")
    mobile = models.CharField(max_length=20, unique=True, verbose_name="手機")
    email = models.CharField(max_length=60, unique=True, verbose_name="電子郵件")

    marriage = models.CharField(
        max_length=10, choices=MARRIAGE_CHOICES, verbose_name="婚姻狀況"
    )

    emergency_contact = models.CharField(max_length=30, verbose_name="緊急聯絡人")
    emergency_tel = models.CharField(max_length=30, verbose_name="緊急聯絡電話")

    reborn = models.DateField(verbose_name="受洗日期")
    ananias = models.CharField(max_length=30, verbose_name="授洗人員")

    personal_pic = models.ImageField(
        upload_to="member_pics/", blank=True, null=True, verbose_name="個人大頭照"
    )

    status = models.CharField(
        max_length=10, choices=STATUS_CHOICES, verbose_name="會友狀態"
    )

    family = models.ForeignKey(
        Family,
        on_delete=models.CASCADE,
        related_name="family_members",
        null=True,
        blank=True,
        verbose_name="家庭",
    )

    tribe = models.CharField(max_length=10, choices=TRIBE_CHOICES, verbose_name="族別")
    job = models.CharField(max_length=30, choices=JOB_CHOICES, verbose_name="職業")

    lecture = models.CharField(
        max_length=20, choices=LECTURE_CHOICES, verbose_name="學歷"
    )

    agreement = models.BooleanField(default=False, verbose_name="是否同意個資條款")
    backup = models.TextField(blank=True, verbose_name="備註")

    def __str__(self):
        return self.name

    class Meta:
        verbose_name = "會友"
        verbose_name_plural = "會友管理"


class Income_item(models.Model):
    created_at = models.DateTimeField(auto_now_add=True, verbose_name="建立時間")
    updated_at = models.DateTimeField(auto_now=True, verbose_name="更新時間")
    name = models.CharField(max_length=30, verbose_name="名稱")
    backup = models.TextField(blank=True, verbose_name="備註")

    def __str__(self):
        return self.name

    class Meta:
        verbose_name = "奉獻收入帳務項目"
        verbose_name_plural = "奉獻收入帳務項目管理"


class Outcome_item(models.Model):
    created_at = models.DateTimeField(auto_now_add=True, verbose_name="建立時間")
    updated_at = models.DateTimeField(auto_now=True, verbose_name="更新時間")
    name = models.CharField(max_length=30, verbose_name="名稱")
    backup = models.TextField(blank=True, verbose_name="備註")

    def __str__(self):
        return self.name

    class Meta:
        verbose_name = "奉獻支出帳務項目"
        verbose_name_plural = "奉獻支出帳務項目管理"


class Income(models.Model):
    created_at = models.DateTimeField(auto_now_add=True, verbose_name="建立時間")
    updated_at = models.DateTimeField(auto_now=True, verbose_name="更新時間")
    record_date = models.DateField(verbose_name="記錄歸屬日期")
    member = models.ForeignKey(
        Member,
        on_delete=models.CASCADE,
        related_name="member_incomes",
        null=True,
        blank=True,
        verbose_name="會友奉獻",
    )
    donate = models.ForeignKey(
        Donate,
        on_delete=models.CASCADE,
        related_name="donate_incomes",
        null=True,
        blank=True,
        verbose_name="非會友奉獻",
    )
    income_item = models.ForeignKey(
        Income_item,
        on_delete=models.CASCADE,
        related_name="income_item_incomes",
        null=True,
        blank=True,
        verbose_name="帳務分類",
    )
    name = models.CharField(max_length=30, verbose_name="內容")
    account = models.IntegerField(
        verbose_name="金額", validators=[MinValueValidator(0)]
    )
    backup = models.TextField(blank=True, verbose_name="備註")

    def __str__(self):
        return f"{self.name} - {self.account} 元"

    class Meta:
        verbose_name = "奉獻收入"
        verbose_name_plural = "奉獻收入管理"


class Outcome(models.Model):
    created_at = models.DateTimeField(auto_now_add=True, verbose_name="建立時間")
    updated_at = models.DateTimeField(auto_now=True, verbose_name="更新時間")
    record_date = models.DateField(verbose_name="記錄歸屬日期")
    outcome_item = models.ForeignKey(
        Outcome_item,
        on_delete=models.CASCADE,
        related_name="outcome_item_outcomes",
        null=True,
        blank=True,
        verbose_name="帳務分類",
    )
    name = models.CharField(max_length=30, verbose_name="內容")
    account = models.IntegerField(
        verbose_name="金額", validators=[MinValueValidator(0)]
    )
    backup = models.TextField(blank=True, verbose_name="備註")

    def __str__(self):
        return self.name

    class Meta:
        verbose_name = "聖工支出"
        verbose_name_plural = "聖工支出管理"


class Course(models.Model):
    created_at = models.DateTimeField(auto_now_add=True, verbose_name="建立時間")
    updated_at = models.DateTimeField(auto_now=True, verbose_name="更新時間")
    start_date = models.DateField(verbose_name="開始日期")
    end_date = models.DateField(verbose_name="結束日期")
    name = models.CharField(max_length=30, verbose_name="課程名稱")
    account = models.IntegerField(
        verbose_name="學費", validators=[MinValueValidator(0)]
    )
    consume = models.IntegerField(
        verbose_name="書費", validators=[MinValueValidator(0)]
    )
    backup = models.TextField(blank=True, verbose_name="備註")

    def __str__(self):
        return f"{self.name} - {self.account} 元"

    class Meta:
        verbose_name = "訓練課程"
        verbose_name_plural = "訓練課程管理"


class Enroll(models.Model):
    created_at = models.DateTimeField(auto_now_add=True, verbose_name="建立時間")
    updated_at = models.DateTimeField(auto_now=True, verbose_name="更新時間")
    member = models.ForeignKey(
        Member,
        on_delete=models.CASCADE,
        related_name="member_enrolls",
        verbose_name="報名會友",
    )
    course = models.ForeignKey(
        Course,
        on_delete=models.CASCADE,
        related_name="course_enrolls",
        verbose_name="報名訓練課程",
    )
    backup = models.TextField(blank=True, verbose_name="備註")

    def __str__(self):
        return f"{self.member} 報名了{self.course}"

    class Meta:
        verbose_name = "訓練課程報名"
        verbose_name_plural = "訓練課程報名管理"
