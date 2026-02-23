from django.contrib import admin

# Register your models here.
from myapp.models import Maker,PModel,Product,PPhoto

admin.site.register(Maker)
admin.site.register(PModel)
admin.site.register(Product)
admin.site.register(PPhoto)
