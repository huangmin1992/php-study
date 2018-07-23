<template>
  <div class="app-container">
    <!-- 搜索 -->
    <div class="filter-container">
      <el-input @keyup.enter.native="handleFilter" style="width: 200px;" class="filter-item" :placeholder="$t('table.title')" v-model="listQuery.title">
      </el-input>
      <el-select @change='handlerSort' style="width: 140px" class="filter-item" v-model="listQuery.sort">
        <el-option v-for="item in sortOptions" :key="item.key" :label="item.label" :value="item.key">
        </el-option>
      </el-select>
      <el-button class="filter-item" type="primary" v-waves icon="el-icon-search" @click="handleFilter">搜索</el-button>
      <el-button class="filter-item" style="margin-left: 10px;" @click="handleCreate" type="primary" icon="el-icon-edit">新增</el-button>
      <el-button class="filter-item" type="primary" :loading="downloadLoading" v-waves icon="el-icon-download" @click="handleDownload">{{$t('table.export')}}</el-button>
    </div>
    <!-- 列表 -->
    <el-table :key='tableKey' :data="list" v-loading="listLoading" border fit highlight-current-row
      style="width: 100%;min-height:1000px;">
      <el-table-column
        prop="id"
        label="ID"
        width="180">
      </el-table-column>
      <el-table-column
        prop="name"
        label="班级名称"
        width="180">
      </el-table-column>
      <el-table-column
        prop="length"
        label="学制"
        width="180">
      </el-table-column>
      <el-table-column
        prop="price"
        label="学费"
        width="180">
      </el-table-column>
      <el-table-column
        prop="startTime"
        label="开班时间"
        width="180">
      </el-table-column>
      <el-table-column
        prop="teacher.name"
        label="授课老师"
        width="180">
      </el-table-column>

      <el-table-column align="center" :label="$t('table.actions')" width="230" class-name="small-padding fixed-width">
        <template slot-scope="scope">
          <el-button type="primary" size="mini" @click="handleUpdate(scope.row)">{{$t('table.edit')}}</el-button>
         <!--  <el-button v-if="scope.row.status!='published'" size="mini" type="success" @click="handleModifyStatus(scope.row,'published')">{{$t('table.publish')}}
          </el-button> -->
          <!-- <el-button v-if="scope.row.status!='draft'" size="mini" @click="handleModifyStatus(scope.row,'draft')">{{$t('table.draft')}}
          </el-button> -->
          <el-button v-if="scope.row.status!='deleted'" size="mini" type="danger" @click="handleDelete(scope.row)">{{$t('table.delete')}}
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <div class="pagination-container">
      <el-pagination background @size-change="handleSizeChange" @current-change="handleCurrentChange" :current-page="listQuery.page" :page-sizes="[10,20,30, 50]" :page-size="listQuery.limit" layout="total, sizes, prev, pager, next, jumper" :total="total">
      </el-pagination>
    </div>

    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <el-form :rules="rules" ref="dataForm" :model="temp" label-position="center" label-width="120px" style='width: 400px; margin-left:50px;'>
        <el-form-item label="班级名称" prop="name">
          <el-input v-model="temp.name"></el-input>
        </el-form-item>
         <el-form-item label="学制" prop="length">
          <el-input v-model="temp.length"></el-input>
        </el-form-item>
        <el-form-item label="学费" prop="price">
          <el-input v-model="temp.price"></el-input>
        </el-form-item>
        <el-form-item label="开班时间" prop="startTime">
          <el-date-picker v-model="temp.startTime" type="datetime" placeholder="请选择开班时间">
          </el-date-picker>
        </el-form-item>
        <el-form-item label="授课老师">
          <el-input disabled v-model="temp.teacher.name"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">{{$t('table.cancel')}}</el-button>
        <el-button v-if="dialogStatus=='create'" type="primary" @click="createData">{{$t('table.confirm')}}</el-button>
        <el-button v-else type="primary" @click="updateData">{{$t('table.confirm')}}</el-button>
      </div>
    </el-dialog>

    <el-dialog title="Reading statistics" :visible.sync="dialogPvVisible">
      <el-table :data="pvData" border fit highlight-current-row style="width: 100%">
        <el-table-column prop="key" label="Channel"> </el-table-column>
        <el-table-column prop="pv" label="Pv"> </el-table-column>
      </el-table>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="dialogPvVisible = false">{{$t('table.confirm')}}</el-button>
      </span>
    </el-dialog>

  </div>
</template>

<script>
import { fetchList, fetchPv, createArticle, updateArticle, deletArticle, getTeacher } from '@/api/grade'
import waves from '@/directive/waves' // 水波纹指令
import { parseTime } from '@/utils'
import { date_format } from '@/utils/common.js'


export default {
  name: 'complexTable',
  directives: {
    waves
  },
  data() {
    return {
      tableKey: 0,
      list: null,
      total: null,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 10,
        importance: undefined,
        title: undefined,
        type: undefined,
        sort: 'DESC'
      },
      importanceOptions: [1, 2, 3],
      sortOptions: [{ label: '升序', key: 'ASC' }, { label: '降序', key: 'DESC' }],
      statusOptions: ['published', 'draft', 'deleted'],
      showReviewer: false,
      temp: {
        id: undefined,
        name:'',
        price: '',
        length: '',
        timestamp: new Date(),
        startTime:'',
        teacher:{name:''}
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: '班级编辑',
        create: '班级新增'
      },
      dialogPvVisible: false,
      pvData: [],
      rules: {
        // timestamp: [{ type: 'date', required: true, message: 'timestamp is required', trigger: 'change' }],
        name: [
          { required: true,message:'请输入班级名称',trigger:'change'}
        ],
        length: [
          { required: true,message:'请输入学制',trigger:'change'}
        ],
        price: [
          { required: true,message:'请输入学费',trigger:'change'}
        ],
        startTime:[{required:true,message:'请选择开班时间'}],
      },
      downloadLoading: false,
      teacherList:[]
    }
  },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        deleted: 'danger'
      }
      return statusMap[status]
    },
    typeFilter(type) {
      return calendarTypeKeyValue[type]
    }
  },
  created() {
    this.getList();
    this.getTeacher();
    // console.log(date_format(new Date().valueOf(),'yyyy-MM-dd HH:mm:ss'))
  },
  methods: {
    getList() {
      this.listLoading = true
      fetchList(this.listQuery).then(response => {
        this.list = response.data.data
        this.list.forEach((item)=>{
          item.startTime = date_format(item.update_time*1000,'yyyy-MM-dd HH:mm:ss');
        })
        this.total = response.data.total
        // Just to simulate the time of the request
        setTimeout(() => {
          this.listLoading = false
        }, 1.5 * 1000)
      })
    },
    //获取老师列表
    getTeacher(){
      getTeacher().then((res)=>{
        this.teacherList = res.data.data;
        console.log(this.teacherList);
      })
    },
    //排序
    handlerSort(){
      this.listQuery.page = 1;
      console.log(this.listQuery.sort);
      this.getList()
    },
    //搜索
    handleFilter() {
      this.listQuery.page = 1
      this.getList()
    },
    handleSizeChange(val) {
      this.listQuery.limit = val
      this.getList()
    },
    handleCurrentChange(val) {
      this.listQuery.page = val
      this.getList()
    },
    handleModifyStatus(row, status) {
      this.$message({
        message: '操作成功',
        type: 'success'
      })
      row.status = status
    },
    resetTemp() {
      this.temp = {
        id: undefined,
        name:'',
        price: '',
        length: '',
        timestamp: new Date(),
        startTime:'',
        teacher:{name:''},
      }
    },
    //新增
    handleCreate() {
      this.resetTemp()
      this.dialogStatus = 'create'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
  //  确认新增
    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          this.temp.id = parseInt(Math.random() * 100) + 1024 // mock a id
          this.temp.update_time = new Date(this.temp.startTime).valueOf();
          createArticle(this.temp).then((res) => {
            // this.list.unshift(this.temp)
            this.list = res.data.content;
            this.list.forEach((item)=>{
              item.startTime = date_format(item.update_time,'yyyy-MM-dd HH:mm:ss');
            })
            this.dialogFormVisible = false
            this.$notify({
              title: '成功',
              message: '创建成功',
              type: 'success',
              duration: 2000
            })
          })
        }
      })
    },
    //编辑
    handleUpdate(row) {
      console.log(row)
      this.temp = Object.assign({}, row) // copy obj
      this.temp.timestamp = new Date(this.temp.timestamp)
      console.log(this.temp);
      this.temp.grade_id = this.temp.teacher.grade_id
      this.dialogStatus = 'update'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    //编辑确认
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          const tempData = Object.assign({}, this.temp)
          tempData.timestamp = +new Date(tempData.timestamp) // change Thu Nov 30 2017 16:41:05 GMT+0800 (CST) to 1512031311464
          console.log(this.temp)
          updateArticle(tempData).then((res) => {
            for (const v of this.list) {
              if (v.id === this.temp.id) {
                const index = this.list.indexOf(v)
                this.list.splice(index, 1, this.temp)
                break
              }
            }
            this.dialogFormVisible = false
            this.$notify({
              title: '成功',
              message: '更新成功',
              type: 'success',
              duration: 2000
            })
          })
        }
      })
    },
  //删除
    handleDelete(row) {
      deletArticle({id:row.id}).then((res)=>{
        this.getList();
        this.$notify({
          title: '成功',
          message: '删除成功',
          type: 'success',
          duration: 2000
        }) 
      })
    },
    handleFetchPv(pv) {
      fetchPv(pv).then(response => {
        this.pvData = response.data.pvData
        this.dialogPvVisible = true
      })
    },
    handleDownload() {
      this.downloadLoading = true
      import('@/vendor/Export2Excel').then(excel => {
        const tHeader = ['name', 'length', 'price', 'create_time']
        const filterVal = ['name', 'length', 'price', 'create_time' ]
        const data = this.formatJson(filterVal, this.list)
        console.log(data);
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'table-list'
        })
        this.downloadLoading = false
      })
    },
    formatJson(filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => {
        if (j === 'timestamp') {
          return parseTime(v[j])
        } else {
          return v[j]
        }
      }))
    }
  }
}
</script>
